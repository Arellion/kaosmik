<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChatMessageModel;
use CodeIgniter\HTTP\ResponseInterface;

class ChatController extends BaseController
{
    protected $current_menu = 'chat';
    protected $title = 'Chat';

    protected $chatMessageModel;
    protected $userModel;

    public function __construct()
    {
        $this->chatMessageModel = model("ChatMessageModel");
        $this->userModel = model("UserModel");
    }

    public function index()
    {
        $users = $this->userModel->where('id !=', auth()->user()->id)->findAll();
        return $this->render('front/chat/choice-receiver', ['users' => $users]);
    }

    public function conversation($receiver_username)
    {
        $receiver = $this->userModel->where('username', $receiver_username)->first();
        if (empty($receiver)) {
            $this->error('utilisateur introuvable');
            return $this->redirect('chat');
        }
        $id_receiver = $receiver->id;
        $id_sender = auth()->getUser()->id;
        $data = $this->chatMessageModel->getConversation($id_sender, $id_receiver);


        return $this->render('front/chat/chat', ['messages' => $data['data'], 'max_page' => $data['max_page'], 'receiver' => $receiver]);
    }

    public function lastMessages()
    {

    }

    public function send()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Requête invalide']);
        }
        $sender_id = auth()->getUser()->id;
        $receiver_id = $this->request->getPost('receiver_id');
        $message = $this->request->getPost('message');

        if (empty($message) || empty($receiver_id)) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Le message ou le destinataire est manquant'
            ]);
        }

        $data = [
            'id_sender' => $sender_id,
            'id_receiver' => $receiver_id,
            'message' => $message,
        ];

        $messageID = $this->chatMessageModel->insert($data);
        if ($messageID) {
            $newMessage = $this->chatMessageModel->find($messageID);

            $htmlBubble = view_cell('BubbleMessageCell', [
                'chat_message' => $newMessage,
                'sender_context' => true,
            ]);

            return $this->response->setJSON([
                'success' => true,
                'html' => $htmlBubble
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'error' => 'Erreur lors de la sauvegarde'
        ]);


    }
}
