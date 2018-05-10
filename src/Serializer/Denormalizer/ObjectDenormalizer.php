<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Serializer\Denormalizer;

use LogicException;
use RuntimeException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

final class ObjectDenormalizer extends ObjectNormalizer
{
    /** @var null|PropertyTypeExtractorInterface */
    private $typeExtractor;

    public function __construct(?ClassMetadataFactoryInterface $classMetadataFactory = null, ?NameConverterInterface $nameConverter = null, ?PropertyAccessorInterface $propertyAccessor = null, ?PropertyTypeExtractorInterface $propertyTypeExtractor = null)
    {
        $this->typeExtractor = $propertyTypeExtractor;

        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor);
    }

    protected function instantiateObject(array &$data, $class, array &$context, \ReflectionClass $reflectionClass, $allowedAttributes, ?string $format = null)
    {
        $object = $this->extractObjectToPopulate($class, $context, static::OBJECT_TO_POPULATE);
        if ($object !== null) {
            unset($context[static::OBJECT_TO_POPULATE]);

            return $object;
        }

        $constructor = $this->getConstructor($data, $class, $context, $reflectionClass, $allowedAttributes);
        if ($constructor !== null) {
            $constructorParameters = $constructor->getParameters();

            $params = [];
            foreach ($constructorParameters as $constructorParameter) {
                $paramName = $constructorParameter->name;
                $key       = $this->nameConverter !== null ? $this->nameConverter->normalize($paramName) : $paramName;

                $allowed = $allowedAttributes === false || \in_array($paramName, $allowedAttributes, true);
                $ignored = ! $this->isAllowedAttribute($class, $paramName, $format, $context);
                if ($constructorParameter->isVariadic()) {
                    if ($allowed && ! $ignored && (isset($data[$key]) || \array_key_exists($key, $data))) {
                        if (! \is_array($data[$paramName])) {
                            throw new RuntimeException(\sprintf('Cannot create an instance of %s from serialized data because the variadic parameter %s can only accept an array.', $class, $constructorParameter->name));
                        }

                        $params = \array_merge($params, $data[$paramName]);
                    }
                } elseif ($allowed && ! $ignored && (isset($data[$key]) || \array_key_exists($key, $data))) {
                    $parameterData = $data[$key];
                    try {
                        if ($constructorParameter->getClass() !== null) {
                            if (! $this->serializer instanceof DenormalizerInterface) {
                                throw new LogicException(\sprintf('Cannot create an instance of %s from serialized data because the serializer inject in "%s" is not a denormalizer', $constructorParameter->getClass(), static::class));
                            }
                            $parameterClass = $constructorParameter->getClass()->getName();
                            $parameterData  = $this->serializer->denormalize($parameterData, $parameterClass, $format, $this->createChildContext($context, $paramName));
                        } else {
                            $parameterData = $this->validateAndDenormalize($class, $paramName, $data[$key], $format, $context);
                        }
                    } catch (\ReflectionException $e) {
                        throw new RuntimeException(\sprintf('Could not determine the class of the parameter "%s".', $key), 0, $e);
                    }

                    // Don't run set for a parameter passed to the constructor
                    $params[] = $parameterData;
                    unset($data[$key]);
                } elseif ($constructorParameter->isDefaultValueAvailable()) {
                    $params[] = $constructorParameter->getDefaultValue();
                } else {
                    throw new RuntimeException(
                        \sprintf(
                            'Cannot create an instance of %s from serialized data because its constructor requires parameter "%s" to be present.',
                            $class,
                            $constructorParameter->name
                        )
                    );
                }
            }

            if ($constructor->isConstructor()) {
                return $reflectionClass->newInstanceArgs($params);
            }

            return $constructor->invokeArgs(null, $params);
        }

        return new $class();
    }

    private function validateAndDenormalize(string $currentClass, string $attribute, $data, ?string $format, array $context)
    {
        $types = $this->typeExtractor->getTypes($currentClass, $attribute);
        if ($this->typeExtractor === null || $types === null) {
            return $data;
        }

        $expectedTypes = [];
        foreach ($types as $type) {
            if ($data === null && $type->isNullable()) {
                return null;
            }

            $collectionValueType = $type->getCollectionValueType();
            if (($collectionValueType !== null) && $type->isCollection() && $collectionValueType->getBuiltinType() === Type::BUILTIN_TYPE_OBJECT) {
                $builtinType = Type::BUILTIN_TYPE_OBJECT;
                $class       = $collectionValueType->getClassName() . '[]';

                $collectionKeyType = $type->getCollectionKeyType();
                if ($collectionKeyType !== null) {
                    $context['key_type'] = $collectionKeyType;
                }
            } else {
                $builtinType = $type->getBuiltinType();
                $class       = $type->getClassName();
            }

            $expectedTypes[Type::BUILTIN_TYPE_OBJECT === $builtinType && $class ? $class : $builtinType] = true;

            if ($builtinType === Type::BUILTIN_TYPE_OBJECT) {
                if (! $this->serializer instanceof DenormalizerInterface) {
                    throw new LogicException(\sprintf('Cannot denormalize attribute "%s" for class "%s" because injected serializer is not a denormalizer', $attribute, $class));
                }

                $childContext = $this->createChildContext($context, $attribute);
                if ($this->serializer->supportsDenormalization($data, $class, $format)) {
                    return $this->serializer->denormalize($data, $class, $format, $childContext);
                }
            }

            // JSON only has a Number type corresponding to both int and float PHP types.
            // PHP's json_encode, JavaScript's JSON.stringify, Go's json.Marshal as well as most other JSON encoders convert
            // floating-point numbers like 12.0 to 12 (the decimal part is dropped when possible).
            // PHP's json_decode automatically converts Numbers without a decimal part to integers.
            // To circumvent this behavior, integers are converted to floats when denormalizing JSON based formats and when
            // a float is expected.
            if ($builtinType === Type::BUILTIN_TYPE_FLOAT && \is_int($data) && \strpos($format, JsonEncoder::FORMAT) !== false) {
                return (float) $data;
            }

            if (\call_user_func('is_' . $builtinType, $data)) {
                return $data;
            }
        }

        if (! empty($context[self::DISABLE_TYPE_ENFORCEMENT])) {
            return $data;
        }

        throw new NotNormalizableValueException(\sprintf('The type of the "%s" attribute for class "%s" must be one of "%s" ("%s" given).', $attribute, $currentClass, \implode('", "', \array_keys($expectedTypes)), \gettype($data)));
    }
}
