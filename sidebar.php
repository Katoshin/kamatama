<aside class="sidebar">
  <?php for( $x = 0; $x < 4; $x++ ){ ?>
  <div class="sidebarContent">
    <div class="sidebarArticle">
      <span class="sidebarArticle__head">おすすめ記事</span>
      <ul class="sidebarArticle__list">
        <?php for( $i = 0; $i < 4; $i++ ){ ?>
        <li class="sidebarArticle__item">
          <div class="container--sptb">
          <a href="" class="boxLink">
          <img class="sidebarArticle__img" src="<?php bloginfo('template_url') ?>/damie.jpg" alt="">
          <span class="sidebarArticle__title">おすすめ記事のたいとるおすすめ記事のたいとるおすすめ記事のたいとる</span>
          </a>
          </div>
        </li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php } ?>
</aside>
