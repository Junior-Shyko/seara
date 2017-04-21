var notify = (function(){

  function success(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      type: 'success',
      styling: 'bootstrap3'
    });
  }

  function info(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      type: 'info',
      styling: 'bootstrap3'
    });
  }

  function warning(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      styling: 'bootstrap3'
    });
  }

  function error(title, msg)
  {
    new PNotify({
      title: title,
      text: msg,
      type: 'error',
      styling: 'bootstrap3'
    });
  }

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
