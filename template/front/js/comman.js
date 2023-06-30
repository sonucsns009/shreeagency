$(document).ready(function(){

  /*======================================
  =            Menu Selection            =
  ======================================*/
  
   $('.cm-dropdown').mouseleave(function(e){
    if($(window).width() > 768)  {
      $('.cm-dropdown').removeClass('dropdown-is-active')
    }
  });
  
  /*=====  End of Menu Selection  ======*/

  $('.navbar-toggler').click(function(){
    $(this).toggleClass('open');
  });
  
  /*===============================
  =            Sliders            =
  ===============================*/
 


  
  /*=====  End of Sliders  ======*/

  
  

  /*============================================
    =            Custom Select Picker            =
    ============================================*/
    
    if($('.cm-select').length){
      $('.cm-select').selectpicker();      
    }
    
    /*=====  End of Custom Select Picker  ======*/

    /*============================================
    =            Header sticky            =
    ============================================*/

  /*============================================
    =            WOW Animation          =
    ============================================*/
      wow = new WOW(
        {
        animateClass: 'animated',
        offset:       100,
        callback:     function(box) {
        console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
        }
        }
        );
        wow.init();
        document.getElementById('moar').onclick = function() {
        var section = document.createElement('section');
        section.className = 'section--purple wow fadeInDown';
        this.parentNode.insertBefore(section, this);
      };
    
})



    // /*============================================
    // =            Header sticky            =
    // ============================================*/

    $(window).scroll(function() {
      if ($(this).scrollTop() > 1){  
          $('header').addClass("sticky");
        }
        else{
          $('header').removeClass("sticky");
        }
        
      });

    // /*============================================
    // =            Scrolling JS          =
    // ============================================*/

function animateFrom(elem, direction) {
  direction = direction || 1;
  var x = 0,
      y = direction * 100;
  if(elem.classList.contains("gs_reveal_fromLeft")) {
    x = -100;
    y = 0;
  } else if (elem.classList.contains("gs_reveal_fromRight")) {
    x = 100;
    y = 0;
  }
  elem.style.transform = "translate(" + x + "px, " + y + "px)";
  elem.style.opacity = "0";
  gsap.fromTo(elem, {x: x, y: y, autoAlpha: 0}, {
    duration: 1.25, 
    x: 0,
    y: 0, 
    autoAlpha: 1, 
    ease: "expo", 
    overwrite: "auto"
  });
}

function hide(elem) {
  gsap.set(elem, {autoAlpha: 0});
}

document.addEventListener("DOMContentLoaded", function() {
  gsap.registerPlugin(ScrollTrigger);
  
  gsap.utils.toArray(".gs_reveal").forEach(function(elem) {
    hide(elem); // assure that the element is hidden when scrolled into view
    
    ScrollTrigger.create({
      trigger: elem,
      onEnter: function() { animateFrom(elem) }, 
      onEnterBack: function() { animateFrom(elem, -1) },
      onLeave: function() { hide(elem) } // assure that the element is hidden when scrolled into view
    });
  });
});
