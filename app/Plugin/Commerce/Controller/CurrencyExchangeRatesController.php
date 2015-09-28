<?php
class CurrencyExchangeRatesController extends AppController {

	var $name = 'CurrencyExchangeRates';
	var $layout = 'admin';

	function admin_index($deleted = 0) {

		$this->CurrencyExchangeRate->recursive = 0;

		if($deleted == 0){
			$paginate['CurrencyExchangeRate']['conditions'][] = 'CurrencyExchangeRate.deleted IS NULL';
		}
		$paginate['CurrencyExchangeRate']['order'] = 'CurrencyExchangeRate.currency ASC, CurrencyExchangeRate.created DESC';
        
        $this->paginate = $paginate;

		$this->set('currencyExchangeRates', $this->paginate());
		$this->set(compact('deleted'));
	}

// 	function admin_add() {
// 		if (!empty($this->data)) {
// 			$this->CurrencyExchangeRate->create();
// 			if ($this->CurrencyExchangeRate->save($this->data)) {
// 				$this->Session->setFlash(__('Kurs waluty został zapisany.', true));
// 				$this->redirect(array('action' => 'index'));
// 			} else {
// 				$this->Session->setFlash(__('Kurs waluty nie został zapisany. Sprawdź formularz i spróbuj ponownie.', true));
// 			}
// 		}
// 	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Nieprawidłowy kurs waluty', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$editedId = $this->data['CurrencyExchangeRate']['id'];
			unset($this->data['CurrencyExchangeRate']['id']);
			if ($this->CurrencyExchangeRate->save($this->data)) {
				$this->CurrencyExchangeRate->id = $editedId;
				$this->CurrencyExchangeRate->saveField('deleted',date('Y-m-d H:i:s'));
				$this->Session->setFlash(__('Kurs waluty został zapisany.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->data['CurrencyExchangeRate']['id'] = $editedId;
				$this->Session->setFlash(__('Kurs waluty nie został zapisany. Sprawdź formularz i spróbuj ponownie.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CurrencyExchangeRate->read(null, $id);
		}
	}

// 	function admin_delete($id = null) {
// 		if (!$id) {
// 			$this->Session->setFlash(__('Invalid id for currency exchange rate', true));
// 			$this->redirect(array('action'=>'index'));
// 		}
// 		if ($this->CurrencyExchangeRate->delete($id)) {
// 			$this->Session->setFlash(__('Currency exchange rate deleted', true));
// 			$this->redirect(array('action'=>'index'));
// 		}
// 		$this->Session->setFlash(__('Currency exchange rate was not deleted', true));
// 		$this->redirect(array('action' => 'index'));
// 	}

}
?>