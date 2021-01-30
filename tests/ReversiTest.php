<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ReversiTest extends TestCase
{
    /**
     * 
     * @return void
     */
    public function testNextMoveTest()
    {
        $testBoard = [
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', 'w', '', '', '', '', '', ''],
            ['', 'w', 'w', 'w', 'b', '', '', ''],
            ['', 'w', '', 'b', 'w', '', '', ''],
            ['', 'w', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
        ];

        $this->json('POST', '/reversi/maxscore', 
            [
                'board' => $testBoard, 
                'player' => 'b', 
                'opponent' => 'w',
                ]
            )->seeJsonEquals(['x' => 3,'y' => 0]);
    }

    /**
     * 
     * @return void
     */
    public function testCornerMoveTest()
    {
        $testBoard = [
            ['', 'w', 'w', 'w', 'w', 'w', 'w', 'b'],
            ['', '', '', '', '', '', '', ''],
            ['', 'w', '', '', '', '', '', ''],
            ['', 'w', 'w', 'w', 'b', '', '', ''],
            ['', 'w', '', 'b', 'w', '', '', ''],
            ['', 'w', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
        ];

        $this->json('POST', '/reversi/maxscore', 
            [
                'board' => $testBoard, 
                'player' => 'b', 
                'opponent' => 'w',
                ]
            )->seeJsonEquals(['x' => 0,'y' => 0]);
    }

    /**
     * 
     * @return void
     */
    public function testNoMoveTest()
    {
        $testBoard = [
            ['w', 'w', 'w', 'w', 'w', 'w', 'w', 'w'],
            ['w', '', 'w', 'w', 'w', 'w', 'w', 'w'],
            ['w', 'w', '', '', '', '', '', ''],
            ['w', 'w', 'w', 'w', '', '', '', ''],
            ['w', 'w', '', '', 'w', '', '', ''],
            ['w', 'w', '', '', '', '', 'b', 'b'],
            ['w', 'w', '', '', '', '', 'b', 'b'],
            ['w', 'w', '', '', '', '', 'b', 'b'],
        ];

        $this->json('POST', '/reversi/maxscore', 
            [
                'board' => $testBoard, 
                'player' => 'b', 
                'opponent' => 'w',
                ]
            )->seeJsonEquals([]);
    }

    /**
     * 
     * @return void
     */
    public function testRandomMoveTest()
    {
        $testBoard = [
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', 'w', 'b', '', '', ''],
            ['', '', '', 'b', 'w', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
        ];

        $response = $this->call('POST', '/reversi/random', 
            [
                'board' => $testBoard, 
                'player' => 'b', 
                'opponent' => 'w',
                ]
            )->getContent();

        $response = json_decode($response, true);
        $this->assertContains($response, [
            ['x' => 4, 'y' => 5],
            ['x' => 2, 'y' => 3],
            ['x' => 5, 'y' => 4],
            ['x' => 3, 'y' => 2]
        ]);
    }

    public function testCanSeeFirstPageTest()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}
