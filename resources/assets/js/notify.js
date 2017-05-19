/**
 * Módulo de notificações com PNotify
 * Esse módulo encapsula diversas funções auxiliares para uso do PNotify
 */
var notify = (function(){

  /**
   * Apresenta uma notificação de sucesso
   * @param  {str} title Título da notificação
   * @param  {str} msg   Mensagem da notificação
   */
  function success(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      type: 'success',
      styling: 'bootstrap3'
    });
  }

  /**
   * Apresenta uma notificação de informação
   * @param  {str} title Título da notificação
   * @param  {str} msg   Mensagem da notificação
   */
  function info(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      type: 'info',
      styling: 'bootstrap3'
    });
  }

  /**
   * Apresenta uma notificação de aviso
   * @param  {str} title Título da notificação
   * @param  {str} msg   Mensagem da notificação
   */
  function warning(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      styling: 'bootstrap3'
    });
  }

  /**
   * Apresenta uma notificação de erro
   * @param  {str} title Título da notificação
   * @param  {str} msg   Mensagem da notificação
   */
  function error(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      type: 'error',
      styling: 'bootstrap3'
    });
  }

  /**
   * Apresenta uma notificação baseada na resposta do servidor
   * Caso a requisição tenha tido alguma falha, será apresentada uma
   * notificação de erro, caso contrário, uma notificação de sucesso
   * @param  {json} data Resposta do servidor
   */
  function response(data)
  {
    if (data["status"] == "success") {
      success("Sucesso", data["message"]);
    }
    else {
      error("Erro", data["message"]);
    }
  }

  return {
    success: success,
    error: error,
    info: info,
    warning: warning,
    response: response
  }

})();
