<?php

declare(strict_types=1);

namespace Marx\Csv;

/**
 * 使用flush分批导出.
 */
class FlushExport extends AbstractExport
{
    /**
     * 文件名.
     */
    private string $filename;

    /**
     * 标题.
     */
    private array $title;

    /**
     * 最大缓冲条数.
     */
    private int $flushCount;

    /**
     * 列表.
     */
    private iterable $list;

    public function __construct()
    {
        $this->setFilename(date('YmdHis'));
        $this->setTitle([]);
        $this->setFlushCount(10000);
    }

    /**
     * 设置文件名.
     *
     * @return static
     */
    public function setFilename(string $filename)
    {
        $this->filename = $this->utf8ToGbk($filename);

        return $this;
    }

    /**
     * 设置标题.
     *
     * @return static
     */
    public function setTitle(array $title)
    {
        $this->title = [];
        foreach ($title as &$field) {
            $this->title[] = $this->utf8ToGbk($field);
        }

        return $this;
    }

    /**
     * 设置最大缓冲条数.
     *
     * @return static
     */
    public function setFlushCount(int $flushCount)
    {
        $this->flushCount = $flushCount;

        return $this;
    }

    /**
     * 设置列表.
     *
     * @return static
     */
    public function setList(iterable $list)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function export(): void
    {
        set_time_limit(0);
        header('Content-type:application/vnd.ms-excel');
        header('Content-Disposition:filename='.$this->filename.'.csv');

        $fp = fopen('php://output', 'a');
        fputcsv($fp, $this->title);

        $num = 0;
        $hasFlush = false;
        foreach ($this->list as $row) {
            $tempRow = [];
            foreach ($row as &$item) {
                $tempRow[] = $this->utf8ToGbk($item."\t");
            }
            fputcsv($fp, $tempRow);
            if (++$num >= $this->flushCount) {
                ob_flush();
                flush();
                $num = 0;
                $hasFlush = true;
            }
        }
        if (0 !== $num || false === $hasFlush) {
            ob_flush();
            flush();
        }

        fclose($fp);
    }
}
