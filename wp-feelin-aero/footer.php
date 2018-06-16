<?php
/**
 * The template for displaying the footer
 */
?>  
  <footer class="footer">
    <div class="container">
      <div class="footer__row footer__row_widget-service">
        <?php get_template_part( 'template-parts/widget', 'service' ); ?>
      </div>
      <div class="footer__row footer__row_content">
        <div class="footer__col footer__col_contact">
          <div class="widget-contact">
            <div class="widget-contact__list">
              <ul class="wt-contact-list">
                <li class="wt-contact-list__item">
                  <b>тел.:</b> +7 9228 25 98 00 
                </li>
                <li class="wt-contact-list__item">
                  <b>тел.:</b> +7 9123 55 00 80
                </li>
                <li class="wt-contact-list__item">
                  <b>e-mail:</b> philipp.khaliavin@gmail.com
                </li>
                <li class="wt-contact-list__item">
                  <b>адрес:</b> г.Оренбург, ул. Салмышская 52, 174
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer__col footer__col_copyright">
          <div class="copyright">
            <div class="copyright__logo"></div>
            <div class="copyright__text">
              feelin-aero.com ©<br>
              Copyright 2012 - 2017
            </div>
          </div>
        </div>
        <div class="footer__col footer__col_metrika">
          <div class="metrika">
            <!-- Yandex.Metrika informer --> <a href="https://metrika.yandex.ru/stat/?id=41641879&amp;from=informer" target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/41641879/3_1_FFFFFFFF_EFEFEFFF_0_pageviews" style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="41641879" data-lang="ru" /></a> <!-- /Yandex.Metrika informer --> <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter41641879 = new Ya.Metrika({ id:41641879, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/41641879" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

            <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
              ga('create', 'UA-96341887-1', 'auto');
              ga('send', 'pageview');
            </script>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <div class="modal fade Fixed" tabindex="-1" role="dialog" id="modal-fly">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Обратный звонок</h4>
        </div>
        <div class="modal-body">
          <?php echo do_shortcode('[contact-form-7 id="979" title="Полетать"]'); ?>
        </div>
      </div>
    </div>
  </div>
</div>      



<?php wp_footer(); ?>
</body>
</html>
