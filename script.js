function getdetails() {
  document.getElementById("mainTable").style.display = "none";
  var cost = $('input[name="cost"]:checked').val();
  var cost_min = $("input[name='cost_min']").val();
  var cost_max = $("input[name='cost_max']").val();
  var value = $('input[name="more"]:checked').val();
  var number = $("input[name='number']").val();
  switch (true){
    case cost_min<=0 || cost_min=="undefined" || isNaN(cost_min):
      alert("Wrong value of the minimum cost!!!");
      break;
    case cost_max<cost_min || cost_max=="undefined" || isNaN(cost_max):
      alert("Wrong value of the maximum cost!!!");
      break;
    case number<0 || number=="undefined" || isNaN(number):
      alert("Wrong value of the maximum cost!!!");
      break;
    default:
      $.ajax({
        type: "GET",
        url: "test2.php",
        data: {cost:cost,cost_min:cost_min,cost_max:cost_max,value:value,number:number},
        dataType:'json',
        success:function(result) {   
          for(var i=0;i<Object.keys(result).length;i++){
            if (i===0){
              $('#getdetails').append('<thead><tr><th>№ <br>п/п</th><th>Наименование</th><th>Розничная<br>стоимость</th>'+
                '<th>Оптовая<br>стоимость</th><th>Склад 1,<br>кол-во</th><th>Склад 2,<br>кол-во</th><th>Страна</th><tr></thead><tbody>');
            }
            $('#getdetails').append('<tr><td>' + result[i].Id + '</td><td>' + result[i].Name + 
              '</td><td>' + result[i].Cost +'</td><td>' + result[i].WholesaleCost + 
              '</td><td>' + result[i].WarehouseOne + '</td><td>' + result[i].WarehouseTwo + 
              '</td><td>' + result[i].Country +  '</td></tr>');
            if (i===Object.keys(result).length-1){
              $('#getdetails').append('</tbody>');
            }
          }
          alert("Done!!!");
        }  
    });
  }
}