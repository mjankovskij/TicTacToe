<?php

namespace App\Controller;

use App\Util\Board;
use App\Util\CPU;
use App\Util\Game;
use App\Util\Validator\BoardValidator;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class TicTacToeController extends AbstractController
{
    private $board;

    public function __construct()
    {
        $this->board = new Board;
    }

    /**
     * @Route("/tictactoe/{level?}", name="tictactoe")
     */
    public function index(): Response
    {
        $board = $this->board->render();
        $session = new Session();
        $session->set('board', $board);

        return $this->render('pages/tictactoe.html.twig', [
            'controller_name' => 'IndexController',
            'board' => $board
        ]);
    }

    /**
     * @Route("/move/{level?}", name="move", methods={"POST"})
     */
    public function move(Request $request, $level = 0)
    {
        if ($level === 'undefined') $level = 0;
        // Request data
        $data = $request->getContent();
        $data = json_decode($data);
        $xCoordinate = $data->xCoordinate;
        $yCoordinate = $data->yCoordinate;


        $session = $request->getSession();
        $board = $session->get('board');
        // print_r($this->board);

        

        $this->board->setBoard($board);

        // // Validation
        // $boardValidator = new BoardValidator;
        // $boardValidator->isBoardValid($board);
        // $boardValidator->isFieldValid($board, $xCoordinate, $yCoordinate);

        // Make move
        $this->board->setMove($xCoordinate, $yCoordinate, 'X');

        $game = new Game;

        if ($game->isGameEnded($this->board)) {
            $board = $session->set('board', $this->board->render());
            return new JsonResponse([
                'board' =>  $this->board->get(),
                'gameResult' => 'You won.'
            ], 200);
        }
        
        $cpu = new CPU;
        $moves = $cpu->getMove($this->board, $level);
        $this->board->setMove($moves[0], $moves[1], 'O');

        $result = false;
        if ($game->isGameEnded($this->board)) {
            $result = $game->isGameEnded($this->board);
            $board = $session->set('board', $this->board->render());
        }

        $board = $session->set('board', $this->board->get());

        return new JsonResponse([
            'board' =>  $this->board->get(),
            'movesPC' => $moves,
            // It is end?
            'gameResult' => $result
        ], 200);
    }
}
