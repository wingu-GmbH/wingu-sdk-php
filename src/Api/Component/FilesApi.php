<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Api\Component;

use Wingu\Engine\SDK\Api\Api;
use Wingu\Engine\SDK\Assertion;
use Wingu\Engine\SDK\Model\Request\Component\Files\Create;
use Wingu\Engine\SDK\Model\Request\Component\Files\File\Create as CreateFile;
use Wingu\Engine\SDK\Model\Request\Component\Files\File\Update as UpdateFile;
use Wingu\Engine\SDK\Model\Response\Component\Files;
use Wingu\Engine\SDK\Model\Response\Component\FilesFile;

final class FilesApi extends Api
{
    public function create(Create $files) : Files
    {
        $request = $this->createPostRequest('/api/component/files', $files);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, Files::class);
    }

    public function createFile(string $id, CreateFile $file) : FilesFile
    {
        Assertion::uuid($id);
        $request = $this->createMultipartPostRequest('/api/component/files/' . $id . '/file', $file);

        $response = $this->handleRequest($request);

        return $this->hydrator->hydrateResponse($response, FilesFile::class);
    }

    public function updateFile(string $id, UpdateFile $file) : void
    {
        Assertion::uuid($id);
        $request = $this->createPatchRequest('/api/component/files/file/' . $id, $file);

        $this->handleRequest($request);
    }
}
