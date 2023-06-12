<?php

use App\StopWatch\Domain\StopWatch;
use App\StopWatch\Enum\Status;
use PHPUnit\Framework\TestCase;

class StopWatchTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     */
    public function 初期状態は計測準備中() {
        $stopWatch = new StopWatch();

        $this->assertEquals(Status::PREPARE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 初期状態の経過時間の表示は００：００() {
        $stopWatch = new StopWatch();
        $this->assertEquals('00:00', $stopWatch->getTime());
    }

    /**
     * @test
     */
    public function 計測準備中にスタートすると計測中になる() {
        $stopWatch = new StopWatch();
        $stopWatch->start();
        $this->assertEquals(Status::MEASURE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 計測準備中に一時停止してもステータスは変わらない() {
        $now = new \DateTimeImmutable();
        $stopDateTime = $now->modify('1 hour 20 minutes 23 seconds');
        $stopWatch = new StopWatch();
        $stopWatch->pause($stopDateTime);
        $this->assertEquals(Status::PREPARE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 計測準備中にリセットしてもステータスは変わらない() {
        $stopWatch = new StopWatch();
        $stopWatch->reset();
        $this->assertEquals(Status::PREPARE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 計測中にスタートしてもステータスは変わらない() {
        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->start();
        $this->assertEquals(Status::MEASURE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 計測中に一時停止すると一時停止ステータスになる() {
        $now = new \DateTimeImmutable();
        $stopDateTime = $now->modify('1 hour 20 minutes 23 seconds');

        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->pause($stopDateTime);
        $this->assertEquals(Status::PAUSE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 計測中に一時停止すると経過時間が更新される() {
        $now = new \DateTimeImmutable();
        $stopDateTime = $now->modify('1 hour 20 minutes 23 seconds');

        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->pause($stopDateTime);
        // 生成中に1秒ずれる？
        $this->assertEquals('20:22', $stopWatch->getTime());
    }

    /**
     * @test
     */
    public function 計測中にリセットしてもステータスは変わらない() {
        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->reset();
        $this->assertEquals(Status::MEASURE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 一時停止中にスタートすると計測中になる() {
        $now = new \DateTimeImmutable();
        $stopDateTime = $now->modify('1 hour 20 minutes 23 seconds');

        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->pause($stopDateTime);
        $stopWatch->start();
        $this->assertEquals(Status::MEASURE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 一時停止中に一時停止してもステータスは変わらない() {
        $now = new \DateTimeImmutable();
        $stopDateTime = $now->modify('1 hour 20 minutes 23 seconds');

        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->pause($stopDateTime);
        $stopWatch->pause($stopDateTime);
        $this->assertEquals(Status::PAUSE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 一時停止中にリセットすると計測準備中になる() {
        $now = new \DateTimeImmutable();
        $stopDateTime = $now->modify('1 hour 20 minutes 23 seconds');

        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->pause($stopDateTime);
        $stopWatch->reset();
        $this->assertEquals(Status::PREPARE, $stopWatch->getStatus());
    }

    /**
     * @test
     */
    public function 一時停止中にリセットすると経過時間が００：００になる() {
        $now = new \DateTimeImmutable();
        $stopDateTime = $now->modify('1 hour 20 minutes 23 seconds');

        $stopWatch = new StopWatch();
        $stopWatch->start();
        $stopWatch->pause($stopDateTime);
        $stopWatch->reset();
        $this->assertEquals('00:00', $stopWatch->getTime());
    }
}