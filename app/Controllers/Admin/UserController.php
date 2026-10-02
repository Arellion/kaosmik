<?php

/**
 * NAMESPACE
 * Déclare l'espace de noms de cette classe.
 * Cela permet à PHP de retrouver et d'organiser les fichiers sans conflit de noms.
 * Ici, ce contrôleur appartient à la section "Admin" de l'application.
 */
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Player;
use App\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;
class UserController extends BaseController
{
    protected $layout = "back";
    private $userModel;
    private $playerModel;

    protected $current_menu = 'user';
    public function __construct()
    {
        $this->userModel = model("UserModel");
        $this->playerModel = model("PlayerModel");
    }

    public function index()
    {
        helper('form');
        $this->title = "Liste des utilisateurs";

        // Récupère tous les utilisateurs depuis la base de données
        $users = $this->userModel->findAll();

        // Envoie les utilisateurs à la vue pour affichage
        return $this->render('admin/user/index', ['users' => $users]);
    }

    public function edit($id = null)
    {
        helper('form');

        // Recherche l'utilisateur par son ID
        $user = $this->userModel->find($id);

        // Passe l'utilisateur à la vue (null si non trouvé, la vue doit le gérer)
        return $this->render('admin/user/form', ['user' => $user]);
    }


    public function new()
    {
        helper('form');
        return $this->render('admin/user/form');
    }

    public function update()
    {
        // getPost() récupère toutes les données envoyées via le formulaire (méthode HTTP POST)
        $data = $this->request->getPost();

        // VALIDATION : on vérifie que l'ID est bien présent dans les données du formulaire.
        // Sans ID, on ne sait pas quel utilisateur modifier → on redirige avec une erreur.
        if (!isset($data['id'])) {
            $this->error('Identifiant inconnu');
            return $this->redirect('/admin/user');
        }

        // On extrait l'ID et on le supprime du tableau $data
        // pour ne pas l'envoyer par erreur dans les champs à mettre à jour.
        $user_id = $data['id'];
        unset($data['id']);

        // RÉCUPÉRATION DES ENTITÉS
        // On charge l'utilisateur depuis la BDD. find() retourne null si introuvable.
        $user = $this->userModel->find($user_id);
        if ($user === null) {
            $this->error('Utilisateur introuvable dans la base de données.');
            return $this->redirect('/admin/user');
        }

        // getPlayer() est une méthode de l'entité User qui charge le Player associé
        // (relation one-to-one via la clé étrangère user_id dans la table players).
        $player = $user->getPlayer();
        if ($player === null) {
            $this->error('Aucun profil de joueur associé à cet utilisateur.');
            return $this->redirect('/admin/user');
        }

        // NORMALISATION DU CHAMP "active" (checkbox HTML)
        if (isset($data['active']) && $data['active'] == 'on') {
            $data['active'] = 1;
        } else {
            $data['active'] = 0;
        }

        //Travail sur l'image
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            helper('media');
            $result = upload_single_image($image, 'users', $data['username'], [
                'entity_type' => 'users',
                'entity_id' => $user_id,
            ]);
            if ($result->status == 'error') {
                $this->error($result['message']);
            }else{
                $this->success('Image téléversé');
            }
        }

        // REMPLISSAGE DES ENTITÉS
        // fill() applique les données du tableau sur les propriétés correspondantes de l'entité.
        // Les champs qui n'existent pas dans l'entité sont ignorés.
        $user->fill($data);
        $player->fill($data);

        // SAUVEGARDE EN BASE DE DONNÉES
        // save() fait un UPDATE si l'entité a un ID, ou un INSERT si elle n'en a pas.
        // Il retourne true en cas de succès, false en cas d'erreur.
        $saveUserOK = $this->userModel->save($user);
        $savePlayerOk = $this->playerModel->save($player);

        if ($saveUserOK == false || $savePlayerOk == false) {
            $this->error('Une erreur est survenue lors de la sauvegarde');
            return $this->redirect('/admin/user/edit/' . $user_id);
        }

        // RETOUR UTILISATEUR : message de succès + redirection
        $this->success($user->username . " à bien été modifié.");
        return $this->redirect('/admin/user/edit/' . $user_id);
    }

    public function create()
    {
        $data = $this->request->getPost();

        // NORMALISATION DU CHAMP "active" (même logique que dans update())
        // L'opérateur ternaire ? : est une façon condensée d'écrire un if/else.
        $data['active'] = (isset($data['active']) && $data['active'] == 'on') ? 1 : 0;

        // ÉTAPE 1 : CRÉATION DE L'UTILISATEUR
        // On instancie une nouvelle entité User (objet vide) et on la remplit avec le formulaire.
        $user = new User();
        $user->fill($data);

        // Shield (le module d'authentification) gère l'email séparément via un système d'identités.
        // On lui assigne directement depuis le champ "mail" du formulaire.
        // ?? '' est l'opérateur "null coalescing" : retourne '' si $data['mail'] n'existe pas.
        $user->email = $data['mail'] ?? '';

        $saveUserOK = $this->userModel->save($user);

        if (!$saveUserOK) {
            $this->error('Une erreur est survenue lors de la création de l\'utilisateur.');
            return $this->redirect('/admin/user/new');
        }

        // getInsertID() retourne l'ID auto-incrémenté généré par le dernier INSERT.
        // On en a besoin pour lier le Player à cet User via la clé étrangère.
        $userId = $this->userModel->getInsertID();

        // Ajoute l'utilisateur au groupe par défaut (rôle de base défini dans la config Shield).
        $this->userModel->addToDefaultGroup($this->userModel->find($userId));

        // ÉTAPE 2 : CRÉATION DU PLAYER ASSOCIÉ
        // Un Player est le profil de jeu lié à un User (relation one-to-one).
        $player = new Player();
        $player->fill($data);

        // On associe le Player à l'User via la clé étrangère user_id.
        // C'est cette valeur qui crée le lien en base de données.
        $player->user_id = $userId;

        $savePlayerOk = $this->playerModel->save($player);

        if (!$savePlayerOk) {
            // L'utilisateur existe déjà en BDD, mais son profil joueur n'a pas pu être créé.
            // On redirige vers l'édition pour permettre de corriger manuellement.
            $this->error('Utilisateur créé, mais impossible de créer le profil joueur.');
            return $this->redirect('/admin/user/edit/' . $userId);
        }

        $this->success("L'utilisateur " . $user->username . " a été créé avec succès.");
        return $this->redirect('/admin/user');
    }
}