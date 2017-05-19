function reloadAllMasks()
{
  $('.money-mask').trigger('input');
  $('.date-mask').trigger('input');
}

$(document).ready(function(){
  $('.money-mask').mask("#.##0,00", {reverse: true});
  $('.date-mask').mask('00/00/0000', {placeholder: "__/__/____"});
});
