<?php

namespace Tests\Database;

use App\Entities\Player;
use App\Models\ChatMessageModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Traits\CreatesPlayers;

final class ChatMessageModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use CreatesPlayers;

    protected $migrate = true;
    protected $refresh = true;
    protected $DBGroup = 'tests';
    protected $namespace = null;

    private Player $player1;
    private Player $player2;

    private ChatMessageModel $messageModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageModel = new ChatMessageModel();
        $this->player1 = $this->createPlayer('joueur1');
        $this->player2 = $this->createPlayer('joueur2');
    }

    public function testCanCreateChatMessage()
    {
        $id = $this->messageModel->insert(
            ['id_sender' => $this->player1->id,
            'id_receiver' => $this->player2->id,
            'message' => 'Le message est bon.']);

        $this->assertIsInt($id);
        $this->SeeInDatabase('test_chat_messages', [
            'id_sender' => $this->player1->id,
            'id_receiver' => $this->player2->id,
            'message' => 'Le message est bon.']);
    }

    public function testCanReadChatMessage()
    {
        $id = $this->messageModel->insert(
            ['id_sender' => $this->player1->id,
                'id_receiver' => $this->player2->id,
                'message' => 'Le message est bon.']);

        $found = $this->messageModel->where('id_receiver', $this->player2->id)->first();

        $this->assertSame('Le message est bon.', $found->message);
    }

    public function testCannotCreateChatMessageForUnknowReceiver()
    {
        $this->expectException(DatabaseException::class);
        $id = $this->messageModel->insert(
            ['id_sender' => $this->player1->id,
            'id_receiver' => 99999,
                'message' => 'Le message est impossible.']
        );
    }

    public function testCannotCreateChatMessageForUnknowSender()
    {
        $this->expectException(DatabaseException::class);
        $id = $this->messageModel->insert([
            'id_sender' => 99999,
            'id_receiver' => $this->player1->id,
            'message' => 'Le message est impossible.'
        ]);
    }


}