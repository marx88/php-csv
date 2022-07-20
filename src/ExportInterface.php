<?php

declare(strict_types=1);

namespace Marx\Csv;

/**
 * 导出接口.
 */
interface ExportInterface
{
    /**
     * 导出.
     */
    public function export(): void;
}
