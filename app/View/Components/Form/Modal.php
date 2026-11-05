<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
	public $modal_id;
	public $modal_title;
	public $modal_large;
	public $btn_modal_lbl;
	public $form_method;
	public $form_name;
	public $form_id;
	public $lbl_btn_cancel;
	public $lbl_btn_accept;

	/**
	 * Create a new component instance.
	 */
	public function __construct(
		$modalId = 'idModal',
		$modalTitle = 'Titulo Modal',
		$modalLarge = 'modal-xl', //,modal-lg
		$btnModalLbl = 'Abrir Modal',
		$formMethod = 'POST',
		$formName = 'nameForm',
		$formId = 'idForm',
		$lblBtnCancel = 'Cancelar',
		$lblBtnAccept = 'Aceptar'
	) {
		$this->modal_id       = $modalId;
		$this->modal_title    = $modalTitle;
		$this->modal_large    = $modalLarge;
		$this->btn_modal_lbl  = $btnModalLbl;
		$this->form_method    = $formMethod;
		$this->form_name      = $formName;
		$this->form_id        = $formId;
		$this->lbl_btn_cancel = $lblBtnCancel;
		$this->lbl_btn_accept = $lblBtnAccept;
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string
	{
		return view('components.form.modal');
	}
}
