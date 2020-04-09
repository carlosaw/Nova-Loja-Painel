<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Permissions;

class PermissionsController extends Controller {

	private $user;
	private $arrayInfo;

	public function __construct() {
		$this->user = new Users();

		if(!$this->user->isLogged()) {
			header("Location: ".BASE_URL."login");
			exit;
		}

		if(!$this->user->hasPermission('permissions_view')) {
			header("Location: ".BASE_URL);
			exit;
		}

		$this->arrayInfo = array(
			'user' => $this->user,
			'menuActive' => 'permissions'
		);  
	}

	public function index() {

		$p = new Permissions();
		$this->arrayInfo['list'] = $p->getAllGroups();

		$this->loadTemplate('permissions', $this->arrayInfo);
	}

	public function items() {
		$p = new Permissions();
		$user = new Users();
		$this->arrayInfo['list'] = $p->getAllItems();
		//$this->arrayInfo['list'] = $p->getAllGroups();

		$this->loadTemplate('permissions_items', $this->arrayInfo);
	
	}
	
	public function items_del($id_item) {
		$p = new Permissions();

		$p->deleteItem($id_item);

		header("Location: ".BASE_URL.'permissions/items');
		exit;
	}
	
	public function del($id_group) {
		$p = new Permissions();

		$p->deleteGroup($id_group);

		header("Location: ".BASE_URL.'permissions');
		exit;
	}

	public function add() {
		$this->arrayInfo['errorItems'] = array();

		$p = new Permissions();

		$this->arrayInfo['permission_items'] = $p->getAllItems();

		if(isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
			$this->arrayInfo['errorItems'] = $_SESSION['formError'];
			unset($_SESSION['formError']);
		}

		$this->loadTemplate('permissions_add', $this->arrayInfo);
	}

	public function items_add() {
		$this->arrayInfo['errorItems'] = array();

		$p = new Permissions();

		$this->arrayInfo['permission_items'] = $p->getAllItems();

		if(isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
			$this->arrayInfo['errorItems'] = $_SESSION['formError'];
			unset($_SESSION['formError']);
		}

		$this->loadTemplate('permissions_items_add', $this->arrayInfo);
	}

	public function add_action() {
		//print_r($_POST);
		$p = new Permissions();

		if(!empty($_POST['name'])) {
			$name = $_POST['name'];
			$id = $p->addGroup($name);

			if(isset($_POST['items']) && count($_POST['items']) > 0) {

				$items = $_POST['items'];

				foreach($items as $item) {
					$p->linkGroupToItem($item, $id);
				}
			}

			header("Location: ".BASE_URL.'permissions');
			exit;

		} else {
			// Observações
			$_SESSION['formError'] = array('name');

			header("Location: ".BASE_URL.'permissions/add');
			exit;
		}
	}

	public function items_add_action() {
		//print_r($_POST);
		$p = new Permissions();

		if(!empty($_POST['name'])) {
			$name = $_POST['name'];
			$slug = $_POST['slug'];
			$id = $p->addItem($name, $slug);

			if(isset($_POST['items']) && count($_POST['items']) > 0) {

				$items = $_POST['items'];
				$slug = $_POST['slug'];
				foreach($items as $item) {
					$p->linkGroupToItem($item, $id);
				}
			}

			header("Location: ".BASE_URL.'permissions/items');
			exit;

		} else {
			// Observações
			$_SESSION['formError'] = array('name');

			header("Location: ".BASE_URL.'permissions/items');
			exit;
		}
	}

	public function edit($id) {
		if(!empty($id)) {
			$this->arrayInfo['errorItems'] = array();

			$p = new Permissions();

			$this->arrayInfo['permission_items'] = $p->getAllItems();
			$this->arrayInfo['permission_id'] = $id;
			$this->arrayInfo['permission_group_name'] = $p->getPermissionGroupName($id);
			$this->arrayInfo['permission_group_slugs'] = $p->getPermissions($id);

			if(isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
				$this->arrayInfo = $_SESSION['formError'];
				unset($_SESSION['formError']);
			}

			$this->loadTemplate('permissions_edit', $this->arrayInfo);
		} else {
			header("Location: ".BASE_URL.'permissions');
			exit;
		}
	}

	public function items_edit($id) {
		if(!empty($id)) {
			$this->arrayInfo['errorItems'] = array();
			
			$p = new Permissions();

			$this->arrayInfo['permission_items'] = $p->getAllItems();
			$this->arrayInfo['permission_id'] = $id;
			$this->arrayInfo['permission_items_name'] = $p->getPermissionItemName($id);
			$this->arrayInfo['permission_items_slug'] = $p->getPermissions($id);

			if(isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
				$this->arrayInfo = $_SESSION['formError'];
				unset($_SESSION['formError']);
			}

			$this->loadTemplate('permissions_items_edit', $this->arrayInfo);
		} else {
			header("Location: ".BASE_URL.'permissions/items');
			exit;
		}
	}

	public function edit_action($id) {
		if(!empty($id)) {

			$p = new Permissions();

		if(!empty($_POST['name'])) {
			$name = $_POST['name'];
			/*
			1. Altera o nome do grupo.
			2. Limpa os Links
			3. Re-linka
			*/
			// 1. Altera o nome do grupo.
			$p->editName($name, $id);
			// 2. Limpa os Links
			$p->clearLinks($id);
			// 3. Re-linka
			if(isset($_POST['items']) && count($_POST['items']) > 0) {

				$items = $_POST['items'];

				foreach($items as $item) {
					$p->linkGroupToItem($item, $id);
				}
			}

			header("Location: ".BASE_URL.'permissions');
			exit;

		} else {
			// Observações
			$_SESSION['formError'] = array('name');

			header("Location: ".BASE_URL.'permissions/edit/'.$id);
			exit;
		}


		} else {
			header("Location: ".BASE_URL.'permissions');
			exit;
		}
	}

	public function items_edit_action($id) {
		if(!empty($id)) {

			$p = new Permissions();

		if(!empty($_POST['name'])) {
			$name = $_POST['name'];
			/*
			1. Altera o nome do grupo.
			2. Limpa os Links
			3. Re-linka
			*/
			// 1. Altera o nome do grupo.
			$p->editItemName($name, $id);
			// 2. Limpa os Links
			$p->clearLinks($id);
			// 3. Re-linka
			if(isset($_POST['items']) && count($_POST['items']) > 0) {

				$items = $_POST['items'];

				foreach($items as $item) {
					$p->linkItemToGroup($item, $id);
				}
			}

			header("Location: ".BASE_URL.'permissions/items');
			exit;

		} else {
			// Observações
			$_SESSION['formError'] = array('name');

			header("Location: ".BASE_URL.'permissions/items_edit/'.$id);
			exit;
		}


		} else {
			header("Location: ".BASE_URL.'permissions');
			exit;
		}
	}

}