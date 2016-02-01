<?php
class Hongbao
{
    private $hongbao = [];
    private $minMoney = 0.01; // 每个人可领取的最小金额（默认1分）
    // 创建红包
    public function create($num = 0, $totalMoney = 0) 
    {
        if (!is_numeric($num) || empty($num) || empty($totalMoney) || $totalMoney / $num < $this->minMoney) {
            return false;
        }
        // 生成红包id
        $id = uniqid();
        // 剩余金额
        $remainingMoney = $totalMoney;
        // 简单算法，抽中的金额必须保证剩余金额能够使剩余每个抽中的金额至少是minMoney
        for ($i = 1; $i < $num; ++$i) { 
            $maxMoney = $remainingMoney - ($num - $i) * $this->minMoney;
            $money = mt_rand($this->minMoney * 100, $maxMoney * 100) / 100;
            $this->hongbao[$id][] = number_format($money, 2, '.', '');
            $remainingMoney -= $money;
        }
        $this->hongbao[$id][] = number_format(round($remainingMoney, 2), 2, '.', '');    // 最后一个剩余金额全放入
        shuffle($this->hongbao[$id]);

        return $id;
    }

    // 领取红包
    public function get($id)
    {
        if (empty($this->hongbao[$id])) {
            return false;
        }
        return array_shift($this->hongbao[$id]);
    }
}