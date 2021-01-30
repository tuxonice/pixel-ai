<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reversi\Reversi;

class ReversiController extends Controller
{

    public function playRandom(Request $request)
    {
        $board = $request->post('board');
        $playerSymbol = $request->post('player');
        $opponentSymbol = $request->post('opponent');

        sleep(1);
        $game = new Reversi($board, $playerSymbol, $opponentSymbol);
        
        return response()->json($game->playRandomPosition());
    }
    
    public function playMaxScore(Request $request)
    {
        $board = $request->post('board');
        $playerSymbol = $request->post('player');
        $opponentSymbol = $request->post('opponent');

        sleep(1);
        $game = new Reversi($board, $playerSymbol, $opponentSymbol);
        
        return response()->json($game->playMaxScorePosition());
    }
    
}
