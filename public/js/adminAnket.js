var base_url = $("base").attr("href");

function lookupFunction(inputString)
{
  if(inputString.length == 0)
  {
    $('#suggestions').hide();
  }
  else
  {
    $.post(base_url + '/ownerController/anketorList', {queryString: ""+inputString+""}, function(data)
    {
      if(data.length > 0)
      {
        $('#suggestions').show();
        $('#autoSuggestionsList').html(data);
      }
    });
  }
}
function systemPost(veri){
    window.location = base_url + "/ownerController/adminProfil/" + veri;
}