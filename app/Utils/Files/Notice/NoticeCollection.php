<?php

namespace App\Utils\Files\Notice;

use Illuminate\Support\Collection;
use App\Domain\Dictionaries\Files\NoticeDictionary;

/**
 * Class NoticeCollection
 * @package App\Utils\Files\Notice
 */
class NoticeCollection extends Collection
{
    /**
     * @return bool
     */
    public function hasCritical(): bool
    {
        return (bool) $this->first(
            function(Notice $notice) {
                return $notice->getLevel() === NoticeDictionary::LEVEL_CRITICAL;
            },
            false
        );
    }
}
