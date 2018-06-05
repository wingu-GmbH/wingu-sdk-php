<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Model\Channel;

use Speicher210\BusinessHours\BusinessHoursInterface;
use Wingu\Engine\SDK\Model\Content\Content;

interface PrivateChannel extends Channel
{
    public function note() : ?string;

    public function isActive() : bool;

    public function content() : ?Content;

    public function isPublished() : bool;

    public function functioningHours() : ?BusinessHoursInterface;

    public function isInFunctioningHours() : bool;
}
