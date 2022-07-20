<?php

declare(strict_types=1);

namespace Marx\Csv;

/**
 * 导出抽象类.
 */
abstract class AbstractExport implements ExportInterface
{
    /**
     * {@inheritDoc}
     */
    abstract public function export(): void;

    /**
     * UTF8编码转GBK编码
     */
    protected function utf8ToGbk(string $str): string
    {
        return mb_convert_encoding($str, 'GBK', 'UTF-8');
    }
}
