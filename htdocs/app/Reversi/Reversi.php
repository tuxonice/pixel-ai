<?php

namespace App\Reversi;

class Reversi 
{
    
    protected $board;
    
    protected $playerSymbol;
    
    protected $opponentSymbol;
    
    public function __construct(array $board, string $playerSymbol, string $opponentSymbol)
    {
        $this->board = $board;
        $this->playerSymbol = $playerSymbol;
        $this->opponentSymbol = $opponentSymbol;
    }
    
    public function playRandomPosition()
    {
        $positionsToPlay = $this->getPositionsToPlay();
        if(count($positionsToPlay)) {
            $position = array_rand($positionsToPlay);
            $xPos = $positionsToPlay[$position][0];
            $yPos = $positionsToPlay[$position][1];
            return ['x' => $xPos, 'y' => $yPos];
        }
        
        return null;
    }
    
    
    public function playMaxScorePosition()
    {
        $positionsToPlay = $this->getPositionsToPlay();
        if(count($positionsToPlay)) {
            $maxScore = 0;
            foreach ($positionsToPlay as $positionToPlay) {
                if ($positionToPlay[2] > $maxScore) {
                    $maxScore = $positionToPlay[2];
                    $xPos = $positionToPlay[0];
                    $yPos = $positionToPlay[1];
                }
            }
            return ['x' => $xPos, 'y' => $yPos];
        }
        
        return null;
    }
    
    protected function getPositionsToPlay()
    {
        $opponentPositions = $this->getOpponentPositions();
        
        $positionsToPlay = [];
        //check empty positions arround each opponent position
        foreach ($opponentPositions as $opponentPosition) {
            for ($x=-1; $x<=1; $x++) {
                for ($y=-1; $y<=1; $y++) {
                    $i = $opponentPosition[0];
                    $j = $opponentPosition[1];
                    if($i+$x < 0 || $i+$x > 7 || $j+$y < 0 || $j+$y > 7) {
                        continue;
                    }
                    if ($this->board[$i+$x][$j+$y] === '') {
                        list($score, $positionsToChange)  = $this->getScoreForPlay($i+$x, $j+$y);
                        if($score > 0) {
                            $positionsToPlay[] = [$i+$x, $j+$y, $score, $positionsToChange];
                        }
                    }
                }
            }
        }
        
        return $positionsToPlay;
    }
    
    
    protected function getScoreForPlay($i, $j)
    {
        $totalScore = 0;
        $positionsToChange = [];
        for($x=-1; $x<=1;$x++) {
            for($y=-1; $y<=1; $y++) {
                if($x == 0 && $y == 0) continue;
                $ni = $i + $x;
                $nj = $j + $y;
                $score = 0;
                $count = 0;
                $positions = [];
                while($ni >= 0 && $ni <=7 && $nj >= 0 && $nj <=7 && $count++ < 50){
                    if($this->board[$ni][$nj] === $this->opponentSymbol) {
                        $positions[] = [$ni, $nj];
                        $score++;
                        $ni += $x;
                        $nj += $y;
                    }elseif($this->board[$ni][$nj] === $this->playerSymbol) {
                        $totalScore+=$score;
                        $positionsToChange = array_merge($positionsToChange,$positions);
                        break;
                    } else {
                        break;
                    }
                }
            }
        }
        
        return [$totalScore, $positionsToChange];
    }
    
    protected function getOpponentPositions()
    {
        $opponentPositions = [];
        for ($i=0;$i<8;$i++) {
            for ($j=0;$j<8;$j++) {
                if ($this->board[$i][$j] === $this->opponentSymbol) {
                    $opponentPositions[] = [$i, $j];
                }
            }
        }

        return $opponentPositions;
    }
    
}
