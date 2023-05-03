<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
//use App\Models\SoftswissModel;
//use App\Models\UserPlayerModel;
//use App\Filters\Auth;
//use App\Models\OperatorModel;

class Home extends ResourceController
{
 	protected $modelName = 'App\Models\Photos';
    protected $format    = 'json';

    public function index1()
    {

        $body = '{
  "casino_id": "sgabet",
  "game": "softswiss:CherryFiesta",
  "locale": "fr",
  "ip": "46.53.162.55",
  "client_type": "mobile",
  "urls": {
    "return_url": "https://example.com"
  },
  "jurisdiction": "DE"
}';

        // print_r($body);exit;

		helper('Softswiss_helper');
        $teste = generateSignature($body);

        print_r($teste);
    }

    public function index()
    {
        /*$request = \Config\Services::request();
        $auth = new Auth();
        $decodedToken = $auth->before($request, 1);
        $postData = $this->request->getPost();
        // $postData = ['game' => 'softswiss:CherryFiesta', 'client_type' => 'desktop'];

        $game = $postData['game'] ?? '';
        $client_type = $postData['client_type'] ?? '';

        if (empty($game)) {
            return $this->fail(lang('Errors.'));            
        } else if (empty($client_type)) {
            return $this->fail(lang('Errors.'));            
        }

        $operatorModel =  new OperatorModel();
        $operator = $operatorModel->getOperatorById($decodedToken->id_operator);

        if ($operator === null) {
            return $this->fail(lang('Errors.'));
        }*/

        $urlsObj = (object) [
            'return_url' => 'https://sys.bet'
        ];

        //$ip = $this->request->getHeaderLine('ip');

        $sessionData = [
            'casino_id' => 'sgabet',
            'game'  => 'softswiss:CherryFiesta',
            //'currency' => 'BRL',
            'locale' => 'BR',
            'ip' => '179.235.209.46',
            'client_type' => 'desktop',
            'urls' => $urlsObj,
            'jurisdiction' => 'BR',
        ];

        helper('Softswiss_helper');
        $signature = generateSignature($sessionData);
       // print_r(json_encode($sessionData));exit;
       // print_r($signature);exit;
        $response = $this->curl($sessionData, $signature, 'demo');

        $response = '{
            "launch_options": {
                "game_url": "https://games.softswiss.net/play/14546",
                "strategy": "detect"
            }
        }';

    }

    public function balanceRequest()
    {
        $request = \Config\Services::request();
        $external_signature = $this->request->getHeaderLine('X-REQUEST-SIGN');

        if (empty($external_signature)) {
            return $this->fail(lang('Errors.'));
        }

        $rawJSON = file_get_contents('php://input');

        helper('Softswiss_helper');
        $validateAndReturnInternalSignature = validateSignature($rawJSON, $external_signature);

        if (! $validateAndReturnInternalSignature) {
            return $this->fail(lang('Errors.'));
        }

        $obj = json_decode($rawJSON);

        $softswissModel = new SoftswissModel();
        $getPlayerBalance = $softswissModel->getPlayerBalance($obj->user_id);

        if ($getPlayerBalance === null) {
            return $this->fail(lang('Errors.'));
        }

        // $response = $this->curl($sessionData, $validateAndReturnInternalSignature, 'demo');

        return $this->respond($getPlayerBalance);

    }

    public function sessions()
    {
        // $session = \Config\Services::session();

        // $sessionData = [
        //     'user_id' => 366663,
        //     'operator_id'  => 659,
        // ];

        // $id = $session->setId('1');
        // print_r($id);exit;
        // $session->set($sessionData);
        // $session->setTempdata($sessionData, null, 1800);
        // exit;

        // $session_id = 'meu_id_personalizado';
        // $session_path = WRITEPATH . 'session';
        
        // $session_handler = new \CodeIgniter\Session\Handlers\FileHandler([
        //     'save_path' => $session_path,
        //     'match_ip'  => false,
        //     'cookie_lifetime' => 1800, // tempo de expiração em segundos
        // ]);
        
        // $session = new \CodeIgniter\Session\Session(new \CodeIgniter\Session\Handlers\FileHandler($session_handler, $session_path), $_COOKIE);
        
        // $session->set('user_id', 'sga');
        // $session->set('operator_id');

        /*$request = \Config\Services::request();
        $auth = new Auth();
        $decodedToken = $auth->before($request, 1);

        $postData = $this->request->getPost();
        // $postData = ['game' => 'softswiss:CherryFiesta', 'client_type' => 'desktop'];
        $game = $postData['game'] ?? '';
        $client_type = $postData['client_type'] ?? '';

        if (empty($game)) {
            return $this->fail(lang('Errors.'));            
        } else if (empty($client_type)) {
            return $this->fail(lang('Errors.'));            
        } 

        $operatorModel =  new OperatorModel();
        $operator = $operatorModel->getOperatorById($decodedToken->id_operator);

        if ($operator === null) {
            return $this->fail(lang('Errors.'));
        }

        $userPlayerModel =  new UserPlayerModel();
        $player = $userPlayerModel->getPlayerById($decodedToken->id_user);

        if ($player === null) {
            return $this->fail(lang('Errors.'));
        }

        $return_url = $operator->url;
        $deposit_url = $return_url . 'deposit';
        $playerName = explode(" ", $player->nome);
        $player_first_name = $playerName[0];
        $player_last_name = end($playerName) != $player_first_name ? end($playerName) : null;*/

        $urlsObj = (object) [
            'deposit_url' => "https://sys.bet/deposit",
            'return_url' => "https://sys.bet/"
        ];

        $playerObj = (object) [
            'id' => "123",
            'email' => "email@email.com",
            'firstname' => "teste",
            'lastname' => "tes123",
            'nickname' => "test",
            'city' => "Recife",
            'country' => 'BRL',
            'date_of_birth' => "1990-07-10",
            'gender' => "m",
            'registered_at' => "2023-04-27",
        ];

        //$ip = $this->request->getHeaderLine('ip');

        $sessionData = [
            'casino_id' => 'sgabet',
            'game'  => 'softswiss:CherryFiesta',
            'currency' => 'BRL',
            'locale' => 'BR',
            'ip' => "179.235.209.46",
            'balance' => '1000', //int64 ?
            'client_type' => 'desktop',
            'urls' => $urlsObj,
            'jurisdiction' => 'BR',
            'user' => $playerObj,
        ];

        helper('Softswiss_helper');
        $signature = generateSignature($sessionData);
        //print_r(json_encode($sessionData));exit;
        $response = $this->curl($sessionData, $signature, 'sessions');

        if ($response['http_code'] != 200) {
         // code...
        }

        $key = 'softswiss-' . $player->id;
        
        $arrayr = [          
            'operator_id' => $player->id_operator,
            'user_id' => $player->id,
        ];

        cache()->save($key, $arrayr, 1800);

        return $this->respond($response);
    }

    public function play()
    {
        $request = \Config\Services::request();
        $external_signature = $this->request->getHeaderLine('X-REQUEST-SIGN');

        if (empty($external_signature)) {
            return $this->fail(lang('Errors.'), 401);
        }

        $rawJSON = file_get_contents('php://input');

        helper('Softswiss_helper');
        $validateAndReturnInternalSignature = validateSignature($rawJSON, $external_signature);

        if (! $validateAndReturnInternalSignature) {
            return $this->fail(lang('Errors.'), 401);
        }

        $obj = json_decode($rawJSON);

        $key = 'softswiss-' . $obj->user_id;

        if (! $arrayr = cache($key)) {
            return $this->fail(lang(), 401);
        }
        
        $userPlayerModel =  new UserPlayerModel();
        $player = $userPlayerModel->getPlayerById($obj->user_id);

        if ($player === null) {
            return $this->fail(lang('Errors.'));
        }

        $softswissModel = new SoftswissModel();
        $logModel = new logModel();
        $actions = $obj->actions;
        $current_date = date("Y-m-d H:i:s");
        $transactionsIds = [];
        $insertedEntrysIds = [];

        foreach($actions as $action) {
            $actionAlreadyExist = $softswissModel->actionAlreadyExist($action->action_id);

            if ($actionAlreadyExist) {
                $action = 'ACTION_DUPLICATED';
                $arrlog = [
                    'id_banca' => $player->id_operator, 
                    'id_usuario' => $obj->user_id, 
                    'action' => $action, 
                    'endpoint' => current_url(), 
                    'browser' => $_SERVER['HTTP_USER_AGENT'], 
                    'device_os' => $_SERVER['HTTP_USER_AGENT'], 
                    'post' => json_encode($action)
                ];
                $logModel->insertLogCassino($arrlog);
                
                if (! empty($arrActionsIds)) {
                    $softswissModel->deleteTransactionCassino($insertedEntrysIds, $transactionsIds);
                }
                return $this->fail(lang('Errors.'));
            }

            $arrBetTransaction = [
                'action_id' => $action->action_id, 
                'user_id' => $obj->user_id, 
                'operation_id' => 10, 
                'game_id' => $obj->game_id, 
                'game' => $obj->game_id, 
                'ag_game_id' => 22, 
                'finished' => $obj->finished, 
                'action' => $action->action, 
                'amount' => $action->amount, 
                'jackpot_contribution' => isset($action->jackpot_contribution) ? $action->jackpot_contribution : null, 
                'jackpot_win' => isset($action->jackpot_contribution) ? 1 : 0,  //???
            ];

            //Insere transação do tipo aposta cassino
            $id_transaction = $softswissModel->insertTransactionCassino($arrBetTransaction);

            if ($action->action == 'bet') {
                $balancePlayer = $softswissModel->decreaseBalanceWithSelect($action->amount, $obj->user_id);
            } else if ($action->action == 'win') {
                $balancePlayer = $softswissModel->increaseBalanceWithSelect($action->amount, $obj->user_id);
            }

            if ($balancePlayer !== NULL) {
                $new_balance = $balancePlayer->balance;
                $old_balance = $player->saldo_online;        

                $arrEntryBet = [
                    'id_usuario' => $obj->user_id, 
                    'id_operacao' => 777, //condicional a bet/win
                    'id_banca' => $player->id_operator, 
                    'valor_solicitado' => $action->amount, 
                    'valor_consolidado' => $action->amount, 
                    'status_operacao' => 3, 
                    'id_reference' => $action->action_id, 
                    'saldo_anterior' => $old_balance,  
                    'saldo_posterior' => $new_balance, 
                    'valor_taxa' => 0, 
                    'game' => $action->action_id, 
                    'data_finalizado' => $current_date
                ];

                //insere o lançamento online da aposta de cassino
                $entryOnlineModel->insertEntryOnline($arrEntryBet);

                $action = 'PlaceBetCassino';
                $arrlog = [
                    'id_banca' => $player->id_operator, 
                    'id_usuario' => $obj->user_id, 
                    'action' => $action, 
                    'endpoint' => current_url(), 
                    'browser' => $_SERVER['HTTP_USER_AGENT'], 
                    'device_os' => $_SERVER['HTTP_USER_AGENT'], 
                    'post' => json_encode($action)
                ];
                
                $logModel->insertLogCassino($arrlog);
                $arrActionsIds[] = $action->action_id;
            } else {
                //Deleta aposta, caso o jogador nao tenha saldo ou não existe
                $softswissModel->deleteTransactionCassino($insertedEntrysIds, $transactionsIds);

                $action = 'PlaceBetCassinoFail';
                $arrLog = [
                    'id_banca' => $player->id_operator, 
                    'id_usuario' => $obj->user_id, 
                    'action' => $action, 
                    'endpoint' => current_url(), 
                    'browser' => $_SERVER['HTTP_USER_AGENT'], 
                    'device_os' => $_SERVER['HTTP_USER_AGENT'], 
                    'post' => json_encode($action)
                ];
                $logModel->insertLogCassino($arrLog);

                return $this->respond($arrFail, 400);
            }

        }

        // $transactions = array(
        //     (object) array(
        //         "action_id" => "123",
        //         "tx_id" => "987",
        //         "processed_at" => "2015-08-29T11:22:09.815479Z",
        //         "bonus_amount" => 100
        //     ),
        //     (object) array(
        //         "action_id" => "124",
        //         "tx_id" => "988",
        //         "processed_at" => "2015-08-29T11:22:09.815479Z"
        //     )
        // );

        // $response = $this->curl($sessionData, $validateAndReturnInternalSignature, 'sessions');

        return $this->respond($arrResponse);

        exit;

        print_r($obj);exit;


    }

    public function hashTest(){
        $body = '{"casino_id":"sgabet","game":"softswiss:CherryFiesta","locale":"BR","ip":"179.235.209.46","client_type":"desktop","urls":{"return_url":"https:\/\/sys.bet"},"jurisdiction":"BR"}'; 
        $hash = hash_hmac('sha256', $body, 'dhf4jdsuhzdza69d');
        print_r($hash);
    }

    public function rollback()
    {
        $getInput = $this->request->getJSON();
        // $body = '{
        //     "user_id": "550e8400-e29b-41d4-a716-446655440000",
        //     "currency": "EUR",
        //     "game": "CherryFiesta",
        //     "game_id": "12",
        //     "finished": true,
        //     "actions": [
        //     {
        //     "action": "rollback",
        //     "action_id": "125",
        //     "original_action_id": "123"
        //     },
        //     {
        //     "action": "rollback",
        //     "action_id": "126",
        //     "original_action_id": "124"
        //     }
        //     ]
        // }';

        // print_r($body);exit;

        helper('Softswiss_helper');
        $teste = generateSignature($body);

        print_r($teste);
    }

    public function index3()
    {

        $body = '{"casino_id":"sgabet", "game":"softswiss:CherryFiesta", "locale":"pt", "ip":"46.53.162.55", "client_type":"mobile", "urls":{"return_url":"https://www.sys.bet/bt"}, "jurisdiction": "BR"}';

        // print_r($body);exit;

        helper('Softswiss_helper');
        $teste = generateSignature($body);

        print_r($teste);
    }

    private function curl($body, $signature, $type){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://casino.int.a8r.games/$type",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	 // CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($body),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "X-REQUEST-SIGN: " . $signature
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        print_r($response);exit;
        echo $response;

    }


}

