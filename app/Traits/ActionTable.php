<?php 

namespace App\Traits;

trait ActionTable 
{
	/**
	 * @param  mix 	  $id Id do registro a receber ação
	 * @param  string $title Título a ser exibido no placeholder
	 * @param  string $click Função javascript a ser executada em cima do id
	 * @param  string $icon String com o ícone font awesome (fa-pencil)
	 * @return string Com o botão de ação formatado
	 */
	function actionButton( $id, $title, $click, $icon, $class = 'btn-primary' )
    {
    	$click = $click . '(' . $id . ')';
        return "<button class='btn {$class} btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='{$title}' onclick='{$click}' role='tooltip'>
                    <i class='fa {$icon}'></i>
                </button>";
    }

    function actionButtons( $id, $actions )
    {
    	$buttons = '';
    	foreach ($actions as $action) 
    	{
    		$buttons .= $this->actionButton( $id, ...$action );
    	}

    	return $buttons;
    }
}