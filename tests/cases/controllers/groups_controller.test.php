<?php
App::import('Controller', 'Newsletter.Groups');

/**
* Controller mock class.
**/ 
class TestGroupsController extends GroupsController {
    var $name = 'Groups';
    var $autoRender = false;
 
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
    
    function paginate($object = null, $scope = array(), $whitelist = array()) {
      return $this->Group->find('all', array('conditions' => $scope));
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}
 
class GroupsControllerTestCase extends CakeTestCase {

    var $fixtures = array('plugin.newsletter.group');
 
    function startTest() {
      $this->Groups = new TestGroupsController();
      $this->Groups->constructClasses();
      $this->Groups->Component->initialize($this->Groups);
    }
    
    function testAdminIndex() {
      $this->Groups->beforeFilter();
      $this->Groups->Component->startup($this->Groups);
      $this->Groups->admin_index();
      
      $this->assertNotNull($this->Groups->viewVars['groups']);
    }
    
    function testAdminAdd() {
      $this->Groups->data = array(
        'Group' => array(
            'name' => 'Fake Group'
        ),
      );
      $this->Groups->beforeFilter();
      $this->Groups->Component->startup($this->Groups);
      $this->Groups->admin_add();
    
      //assert the record was changed
      $result = $this->Groups->Group->read(null, $this->Groups->Group->id);
      $this->assertEqual($result['Group']['name'], 'Fake Group');
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Groups->Session->check('Message.flash.message'));
      $this->assertEqual($this->Groups->redirectUrl, array('action' => 'edit', 'id' => $this->Groups->Group->id));
    }
    
    function testAdminEdit() {
      $this->Groups->data = array(
        'Group' => array(
            'id' => 1,
            'name' => 'Fake Group',
        ),
      );
      $this->Groups->beforeFilter();
      $this->Groups->Component->startup($this->Groups);
      $this->Groups->admin_edit();
    
      //assert the record was changed
      $result = $this->Groups->Group->read(null, 1);
      $this->assertEqual($result['Group']['name'], 'Fake Group');
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Groups->Session->check('Message.flash.message'));
      $this->assertEqual($this->Groups->redirectUrl, array('action' => 'index'));
      
      //test for edit without data
      $this->Groups->beforeFilter();
      $this->Groups->Component->startup($this->Groups);
      $this->Groups->admin_edit(1);
      
      $this->assertNotNull($this->Groups->data);
    }
    
    function testAdminDelete() {
      $this->Groups->beforeFilter();
      $this->Groups->Component->startup($this->Groups);
      $this->Groups->admin_delete(1);
    
      //assert the record was changed
      $result = $this->Groups->Group->read(null, 1);
      $this->assertFalse($result);
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Groups->Session->check('Message.flash.message'));
      $this->assertEqual($this->Groups->redirectUrl, array('action' => 'index'));
    }
 
    function endTest() {
      $this->Groups->Session->destroy();
      unset($this->Groups);
      ClassRegistry::flush();
    }
}
?>
