<div class="breadcrumb">
    <ul class="breadcrumb__list">
      <li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo home_url(); ?>" itemprop="url">
          <span itemprop="title">ホーム</span>
        </a> &rsaquo;
      </li>
      <?php if(is_single()){ ?>
        <?php $postcat = get_the_category(); ?>
        <?php $catid = $postcat[0]->cat_ID; ?>
        <li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo get_category_link($catid); ?>" itemprop="url">
        <span itemprop="title"><?php echo get_cat_name($catid); ?></span>
        </a> &rsaquo;
      </li>
        <?php /*--- 記事タイトル --- */ ?>
        <li class="breadcrumb__item" ><?php the_title(); ?></li>
      <?php }elseif(is_category()){ ?>
        <?php $catid = $cat; /* 表示中のカテゴリーIDをセット */ ?>
        <?php $allcats = array(); /* 親カテゴリーをセットする配列を初期化しておく */ ?>
        <?php
          while(!$catid==0) {	/* すべてのカテゴリーIDを取得し配列にセットするループ */
	          $mycat = get_category($catid); 	/* カテゴリーIDをセット */
	          $catid = $mycat->parent; 	/* 上で取得したカテゴリーIDの親カテゴリーをセット */
	          array_push($allcats, $catid);
          }
          array_pop($allcats);
          $allcats = array_reverse($allcats);
        ?>
        <?php /*--- 親カテゴリーがある場合は表示させる --- */ ?>
        <?php foreach($allcats as $catid): ?>
          <li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo get_category_link($catid); ?>" itemprop="url">
              <span itemprop="title"><?php echo get_cat_name($catid); ?></span>
            </a> &rsaquo;
          </li>
        <?php endforeach; ?>
        <?php /*--- 最下層のカテゴリ名を表示 --- */ ?>
        <li class="breadcrumb__item" ><?php single_cat_title(); ?></li>
      <?php }elseif(is_archive()){ ?>
      <?php }elseif(is_tag()){ ?>
      <?php }elseif(is_tag()){ ?>
      <?php } ?>
    </ul>
</div>
