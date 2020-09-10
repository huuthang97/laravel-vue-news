<template>
    <div>
        <div class="flash-news-banner">
          <div class="container">
            <div class="d-lg-flex">
              <span class="mr-3 text-danger">{{ today }}</span>
              <span class="text-danger"><span id="degree"></span> °C, <span id="city"></span></span>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    name: "Weather",
    data() {
        return {
            today: "",
            city: "",
            degree: "12"
        }
    },
    methods: {
      getWeather() {
        let settings = {
          "url": "http://api.openweathermap.org/data/2.5/weather?q=Hanoi&appid=f6f1a77224edd522fa5f83c03d34cbbb",
          "method": "GET",
          "timeout": 0,
        };

        $.ajax(settings).done(function (res) {
          let city = res.name;
          let degree = res.main.temp  - 273;
          degree = Math.floor(degree);
          
          $("#city").text(city);
          $("#degree").text(degree);
        });


      }
    },
    created() {
        this.today = moment().format('LL'); 
        this.getWeather();
        
    },

}
</script>

<style>

</style>