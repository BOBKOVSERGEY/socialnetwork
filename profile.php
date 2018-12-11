<?php
require __DIR__ . '/init.php';


$username = '';
$verified = false;
$isFollowing = false;

if (isset($_GET['username'])) {
  if (DB::query('SELECT username FROM users WHERE username=:username', [':username' => $_GET['username']])) {
    $username = DB::query('SELECT username FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['username'];
    $verified = DB::query('SELECT verified FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['verified'];
    $userid = DB::query('SELECT id FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['id'];
    $followerid = Login::isLoggedIn();

    if (isset($_POST['follow'])) {
      if ($userid != $followerid) {
        if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', [':userid' => $userid, ':followerid' => $followerid])) {
          if ($followerid == 14) {
            DB::query('UPDATE users SET verified=1 WHERE id=:userid', [':userid' => $userid]);
          }
          DB::query('INSERT INTO followers VALUES (null, :userid, :followerid)', ['userid' => $userid, ':followerid' => $followerid]);
        } else {
          echo 'Already following!';
        }
        $isFollowing = true;
      }
    }

    if (isset($_POST['unfollow'])) {
      if ($userid != $followerid) {
        if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', [':userid' => $userid, ':followerid' => $followerid])) {
          if ($followerid == 14) {
            DB::query('UPDATE users SET verified=0 WHERE id=:userid', [':userid' => $userid]);
          }
          DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', ['userid' => $userid, ':followerid' => $followerid]);
        }
        $isFollowing = false;
      }
    }

    if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', [':userid' => $userid, ':followerid' => $followerid])) {
      $isFollowing = true;
    }

    if (isset($_POST['deletepost'])) {
      if (DB::query('SELECT id FROM posts WHERE id=:postid AND user_id=:userid', [':postid' => $_GET['postid'], ':userid' => $followerid])) {
        DB::query('DELETE FROM posts WHERE id=:postid AND user_id=:userid',[':postid'=> $_GET['postid'], ':userid' => $followerid]);
        DB::query('DELETE FROM post_likes WHERE post_id=:postid',[':postid'=> $_GET['postid']]);
        echo 'Post deleted';
      } else {
        echo 'Something wrong!';
      }
    }

    if (isset($_POST['post'])) {
      if ($_FILES['postimg']['size'] == 0) {
        Post::createPost(Base::security($_POST['postbody']), Login::isLoggedIn(), $userid);
      } else {
        $postid = Post::createImgPost(Base::security($_POST['postbody']), Login::isLoggedIn(), $userid);
        Image::uploadImage('postimg','UPDATE posts SET postimg=:postimg WHERE id=:postid', [':postid'=> $postid]);
      }
    }

    if (isset($_GET['postid']) && !isset($_POST['deletepost'])) {
      Post::likePost($_GET['postid'], $followerid);
    }

    $posts = Post::displayPosts($userid, $username, $followerid);

  } else {
    die('User not found!');
  }
}

?>


<!--<h1><?php echo $username?>'s Profile<?php if ($verified) echo '-Verified'; ?></h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $username; ?>" method="post">
  <?php if ($userid != $followerid) { if ($isFollowing) { ?>
    <input type="submit" name="unfollow" value="Unfollow">
  <?php } else { ?>
    <input type="submit" name="follow" value="Follow">
  <?php } }?>
</form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $username; ?>" method="post" enctype="multipart/form-data">
  <textarea name="postbody" id="" cols="50" rows="10"></textarea><br>
  Upload an image:
  <input type="file" name="postimg"><br><br>
  <input type="submit" name="post" value="Post">
</form>

<div class="posts">
  <?php echo $posts; ?>
</div>-->


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Social Network</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
  <link rel="stylesheet" href="assets/css/Footer-Dark.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
  <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
  <link rel="stylesheet" href="assets/css/Navigation-Clean1.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
<header class="hidden-sm hidden-md hidden-lg">
  <div class="searchbox">
    <form>
      <h1 class="text-left">Social Network</h1>
      <div class="searchbox"><i class="glyphicon glyphicon-search"></i>
        <input class="form-control sbox" type="text">
        <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index:100">
        </ul>
      </div>
      <div class="dropdown">
        <button class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">MENU <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li role="presentation"><a href="#">My Profile</a></li>
          <li class="divider" role="presentation"></li>
          <li role="presentation"><a href="#">Timeline </a></li>
          <li role="presentation"><a href="#">Messages </a></li>
          <li role="presentation"><a href="#">Notifications </a></li>
          <li role="presentation"><a href="#">My Account</a></li>
          <li role="presentation"><a href="#">Logout </a></li>
        </ul>
      </div>
    </form>
  </div>
  <hr>
</header>
<div>
  <nav class="navbar navbar-default hidden-xs navigation-clean">
    <div class="container">
      <div class="navbar-header"><a class="navbar-brand navbar-link" href="#"><i class="icon ion-ios-navigate"></i></a>
        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      </div>
      <div class="collapse navbar-collapse" id="navcol-1">
        <form class="navbar-form navbar-left">
          <div class="searchbox"><i class="glyphicon glyphicon-search"></i>
            <input class="form-control sbox" type="text">
            <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index:100">

            </ul>
          </div>
        </form>
        <ul class="nav navbar-nav hidden-md hidden-lg navbar-right">
          <li role="presentation"><a href="#">My Timeline</a></li>
          <li class="dropdown open"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" href="#">User <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right" role="menu">
              <li role="presentation"><a href="#">My Profile</a></li>
              <li class="divider" role="presentation"></li>
              <li role="presentation"><a href="#">Timeline </a></li>
              <li role="presentation"><a href="#">Messages </a></li>
              <li role="presentation"><a href="#">Notifications </a></li>
              <li role="presentation"><a href="#">My Account</a></li>
              <li role="presentation"><a href="#">Logout </a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav hidden-xs hidden-sm navbar-right">
          <li class="active" role="presentation"><a href="#">Timeline</a></li>
          <li role="presentation"><a href="#">Messages</a></li>
          <li role="presentation"><a href="#">Notifications</a></li>
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">User <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right" role="menu">
              <li role="presentation"><a href="#">My Profile</a></li>
              <li class="divider" role="presentation"></li>
              <li role="presentation"><a href="#">Timeline </a></li>
              <li role="presentation"><a href="#">Messages </a></li>
              <li role="presentation"><a href="#">Notifications </a></li>
              <li role="presentation"><a href="#">My Account</a></li>
              <li role="presentation"><a href="#">Logout </a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>
<div class="container">
  <h1><?php echo $username?>'s Profile <?php if ($verified) echo '<i class="glyphicon glyphicon-ok-sign verified" data-toggle="tooltip" title="Verified User" style="font-size:28px;color:#da052b;"></i>'; ?></h1>

  <div class="row">
    <div class="col-md-3">
      <ul class="list-group">
        <li class="list-group-item"><span><strong>About Me</strong></span>
          <p>Welcome to my profile bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;bla bla&nbsp;</p>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="list-group">
        <div class="timelineposts">

        </div>
      </ul>
    </div>
    <div class="col-md-3">
      <button class="btn btn-default newPost" type="button" style="width:100%;background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;">NEW POST</button>
      <ul class="list-group"></ul>
    </div>
  </div>
</div>
<div class="modal fade" id="commentsmodal" role="dialog" tabindex="-1" style="padding-top:100px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Comments</h4></div>
      <div class="modal-body" style="max-height: 400px; overflow-y: auto">
        <p>The content of your modal.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="newpost" role="dialog" tabindex="-1" style="padding-top:100px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">New Post</h4></div>
      <div style="max-height: 400px; overflow-y: auto">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $username; ?>" method="post" enctype="multipart/form-data">
          <textarea name="postbody" id="" cols="50" rows="10"></textarea><br>
          Upload an image:
          <input type="file" name="postimg"><br><br>
          <input type="submit" name="post" value="Post">
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>
<div class="footer-dark">
  <footer>
    <div class="container">
      <p class="copyright">Social Network© 2016</p>
    </div>
  </footer>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
<script type="text/javascript">
  $(function () {

    function scrollToAnchor(aid){
      var aTag = $(aid);
      var top = aTag.offset().top;
      $('html,body').animate({scrollTop: top},1500);
    }

    $.ajax({

      type: "GET",
      url: "api/profileposts?username=<?php echo $username; ?>",
      processData: false,
      contentType: "application/json",
      data: '',
      success: function(r) {
        r = r.replace(/\\n/g, "\\n")
          .replace(/\\'/g, "\\'")
          .replace(/\\"/g, '\\"')
          .replace(/\\&/g, "\\&")
          .replace(/\\r/g, "\\r")
          .replace(/\\t/g, "\\t")
          .replace(/\\b/g, "\\b")
          .replace(/\\f/g, "\\f");
        r = r.replace(/[\u0000-\u0019]+/g,"");

        var posts = JSON.parse(r);
        $.each(posts, function (index) {
          if (posts[index].PostImg != '') {
            $('.timelineposts').html(
              $('.timelineposts').html() + '<li class="list-group-item" id="' + posts[index].PostId + '"><blockquote><p>'+posts[index].PostBody+'</p><footer>Posted by '+posts[index].PostedBy+' on '+posts[index].PostDate+'<button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id="'+posts[index].PostId+'"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-post-id="'+posts[index].PostId+'" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer><div><img style="max-width: 100%" src="' + posts[index].PostImg+'" alt=""></div></blockquote></li>'
            )

            $('[data-post-id]').on('click', function () {
              var buttonId = $(this).attr('data-post-id');
              $.ajax({

                type: "GET",
                url: "api/comments?postid=" + $(this).attr('data-post-id'),
                processData: false,
                contentType: "application/json",
                data: '',
                success: function (r) {
                  r = r.replace(/\\n/g, "\\n")
                    .replace(/\\'/g, "\\'")
                    .replace(/\\"/g, '\\"')
                    .replace(/\\&/g, "\\&")
                    .replace(/\\r/g, "\\r")
                    .replace(/\\t/g, "\\t")
                    .replace(/\\b/g, "\\b")
                    .replace(/\\f/g, "\\f");
                  r = r.replace(/[\u0000-\u0019]+/g,"");
                  if (r != '') {
                    var comments = JSON.parse(r);
                    showCommentsModal(comments);
                  }
                },
                error: function (r) {
                  console.log(r);
                }
              });

            });

            $('[data-id]').on('click', function () {
              var buttonId = $(this).attr('data-id');
              $.ajax({
                type: "POST",
                url: "api/likes?id=" + $(this).attr('data-id'),
                processData: false,
                contentType: "application/json",
                data: '',
                success: function (r) {
                  var res = JSON.parse(r)
                  console.log(res);
                  console.log(buttonId);
                  $("[data-id='"+buttonId+"']").html(' <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+res.Likes+' Likes</span>')
                },
                error: function (r) {
                  console.log(r);
                }
              })
            })

          } else {
            $('.timelineposts').html(
              $('.timelineposts').html() + '<li class="list-group-item" id="' + posts[index].PostId + '"><blockquote><p>'+posts[index].PostBody+'</p><footer>Posted by '+posts[index].PostedBy+' on '+posts[index].PostDate+'<button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id="'+posts[index].PostId+'"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-post-id="'+posts[index].PostId+'" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li>'
            )

            $('[data-post-id]').on('click', function () {
              var buttonId = $(this).attr('data-post-id');
              $.ajax({

                type: "GET",
                url: "api/comments?postid=" + $(this).attr('data-post-id'),
                processData: false,
                contentType: "application/json",
                data: '',
                success: function (r) {
                  r = r.replace(/\\n/g, "\\n")
                    .replace(/\\'/g, "\\'")
                    .replace(/\\"/g, '\\"')
                    .replace(/\\&/g, "\\&")
                    .replace(/\\r/g, "\\r")
                    .replace(/\\t/g, "\\t")
                    .replace(/\\b/g, "\\b")
                    .replace(/\\f/g, "\\f");
                  r = r.replace(/[\u0000-\u0019]+/g,"");
                  if (r != '') {
                    var comments = JSON.parse(r);
                    showCommentsModal(comments);
                  }
                },
                error: function (r) {
                  console.log(r);
                }
              });
            });

            $('[data-id]').on('click', function () {
              var buttonId = $(this).attr('data-id');
              $.ajax({
                type: "POST",
                url: "api/likes?id=" + $(this).attr('data-id'),
                processData: false,
                contentType: "application/json",
                data: '',
                success: function (r) {
                  var res = JSON.parse(r);
                  $("[data-id='"+buttonId+"']").html(' <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+res.Likes+' Likes</span>')
                },
                error: function (r) {

                }
              })
            })
          }

        });
        /* var posts = JSON.parse(r)
         $.each(posts, function(index) {
           $('.timelineposts').html(
             $('.timelineposts').html() + '<blockquote><p>'+posts[index].PostBody+'</p><footer>Posted by '+posts[index].PostedBy+' on '+posts[index].PostDate+'<button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote>'
           )
         })*/
        if (location.hash) {
          scrollToAnchor(location.hash)
        }

      },
      error: function(r) {
        console.log(r)
      }

    });


    
    function showNewPostModal() {
      $('#newpost').modal('show');
    }

    $('.newPost').on('click', function () {
      showNewPostModal();
    });


    function showCommentsModal(res) {
      $('#commentsmodal').modal('show');

      var output = '';
      for (var i = 0; i < res.length; i++) {
        output += res[i].Comment;
        output += ' ~ ';
        output += res[i].CommentedBy;
        output += '<hr>';
      }

      $('.modal-body').html(output);
    }

  })


</script>
</body>

</html>

