<?php 
$this->load('header.php');
?>
<!-- main content -->
  <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-preview">
            <a href="post.html">
              <h2 class="post-title">
                <?php echo $post_title; ?>
              </h2>
              <h3 class="post-subtitle">
                <?php echo $post_subtitle; ?>
              </h3>
            </a>
            <p class="post-meta">Powered by
              <a href="#"><?php echo $title; ?></a>
              on <?php echo makeDate(date("Y-m-d")); ?></p>
          </div>
          
          <hr>
          <!-- Pager -->
          <div class="clearfix">
            <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
          </div>
        </div>
      </div>
    </div>
<?php 
$this->load('footer.php');
?>
