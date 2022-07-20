<?php

declare(strict_types=1);

namespace Marx\Csv\Test;

use Marx\Csv\FlushExport;

/**
 * flush分批导出测试.
 */
class FlushExportTest
{
    public function test()
    {
        $obj = new FlushExport();
        $obj->setFilename('测试'.date('YmdHis'))
            ->setTitle(['序号', '姓名', '出生日期', '证件号码'])
            ->setFlushCount(20)
            ->setList($this->getList())
            ->export()
        ;
    }

    private function getList()
    {
        for ($i = 0; $i < 1000; ++$i) {
            $num = $i + 3000;
            $day = date('Y-m-d H:i:s', strtotime("-{$num} days"));
            $card = '110260'.date('Ymd', strtotime($day)).str_pad((string) $i, 4, '0', STR_PAD_LEFT);

            yield [$num, '名'.$i, $day, $card];
        }
    }
}
