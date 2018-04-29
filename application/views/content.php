
<div class="content-wrapper">

  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d506820.30933900096!2d106.85969946432458!3d-7.063947575632933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e685c94c7ba9b61%3A0x301e8f1fc28b9f0!2sCianjur+Regency%2C+West+Java!5e0!3m2!1sen!2sid!4v1523368237729" width="100%" height="510" frameborder="0" style="border:0" allowfullscreen></iframe>

</div>


<script>
  function initMap() {
    var uluru = {lat: 1.1321033, lng: 119.2250863};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: uluru
    });

  var segitiga = [
    {lat: 7.472579, lng: 118.889035},
    {lat: -9.296144, lng: 105.529660},
    {lat: -9.729553, lng: 131.149777}
  ];

  var bentukSegitiga = new google.maps.Polygon({
      paths: segitiga,
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35
    });

    bentukSegitiga.setMap(map);

   }
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAF8AG-zP49YRRCMIKfJz4v6RMY1dSJ9s&callback=initMap">
</script>
