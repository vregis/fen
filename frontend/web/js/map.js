// Создает обработчик события window.onLoad
if (screen.width <= 860) {
  var mapCenter = [50.424096, 30.531302];
} else {
  var mapCenter = [50.419883, 30.534437];
}
ymaps.ready(init);
   var myMap,
       myPlacemark;

   function init(){

       myMap = new ymaps.Map ("map", {
          center: mapCenter,
          zoom: 16
       });

       

       myPlacemark = new ymaps.Placemark([50.420096, 30.531302], null, {
           iconLayout: 'default#image',
           iconImageHref: '../img/Metka.png',
            iconImageSize: [78, 120],
            iconImageOffset: [-20, -120],
       });
       myMap.geoObjects.add(myPlacemark);
   }
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiIiwic291cmNlcyI6WyJtYXAuanMiXSwic291cmNlc0NvbnRlbnQiOlsiLy8g0KHQvtC30LTQsNC10YIg0L7QsdGA0LDQsdC+0YLRh9C40Log0YHQvtCx0YvRgtC40Y8gd2luZG93Lm9uTG9hZFxuaWYgKHNjcmVlbi53aWR0aCA8PSA4NjApIHtcbiAgdmFyIG1hcENlbnRlciA9IFs1MC40MjQwOTYsIDMwLjUzMTMwMl07XG59IGVsc2Uge1xuICB2YXIgbWFwQ2VudGVyID0gWzUwLjQxOTg4MywgMzAuNTM0NDM3XTtcbn1cbnltYXBzLnJlYWR5KGluaXQpO1xuICAgdmFyIG15TWFwLFxuICAgICAgIG15UGxhY2VtYXJrO1xuXG4gICBmdW5jdGlvbiBpbml0KCl7XG5cbiAgICAgICBteU1hcCA9IG5ldyB5bWFwcy5NYXAgKFwibWFwXCIsIHtcbiAgICAgICAgICBjZW50ZXI6IG1hcENlbnRlcixcbiAgICAgICAgICB6b29tOiAxNlxuICAgICAgIH0pO1xuXG4gICAgICAgXG5cbiAgICAgICBteVBsYWNlbWFyayA9IG5ldyB5bWFwcy5QbGFjZW1hcmsoWzUwLjQyMDA5NiwgMzAuNTMxMzAyXSwgbnVsbCwge1xuICAgICAgICAgICBpY29uTGF5b3V0OiAnZGVmYXVsdCNpbWFnZScsXG4gICAgICAgICAgIGljb25JbWFnZUhyZWY6ICcuLi9pbWcvTWV0a2EucG5nJyxcbiAgICAgICAgICAgIGljb25JbWFnZVNpemU6IFs3OCwgMTIwXSxcbiAgICAgICAgICAgIGljb25JbWFnZU9mZnNldDogWy0yMCwgLTEyMF0sXG4gICAgICAgfSk7XG4gICAgICAgbXlNYXAuZ2VvT2JqZWN0cy5hZGQobXlQbGFjZW1hcmspO1xuICAgfSJdLCJmaWxlIjoibWFwLmpzIiwic291cmNlUm9vdCI6Ii9zb3VyY2UvIn0=
