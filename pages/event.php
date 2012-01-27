<?php
include_once 'header.php';

if (!empty($_POST)) {

    $eventId = App::getRepository('Comment')->create($_POST);

    $_SESSION['flash']['type'] = 'success';
    $_SESSION['flash']['message'] = 'Successfully added event!.';

    header('Location: ' . ViewHelper::url('?page=event&id=' . $eventId, true));
    exit;
}

$event = App::getRepository('Event')->getEventById($_GET['id']);
$talks = App::getRepository('Talk')->getTalksByEvent($_GET['id']);
$categories = App::getRepository('Category')->getAllCategories();
$comments = App::getRepository('Comment')->getCommentsByEvent($_GET['id']);
?>

<div class="content">

    <div class="row">

        <div id="main-content" class="span10">

<?php ViewHelper::flushMessage(); ?>

            <div class="row single-event">

                <div class="span2" style="padding: 10px 0 10px 10px;">
<?php if (!empty($event['logo'])): ?>
                        <img src="<?php echo $event['logo'] ?>" />
                    <?php else: ?>
                        <img src="http://placehold.it/90x90" />
                    <?php endif; ?>
                </div>

                <div class="span7">
                    <h2><?php echo $event['title'] ?></h2>
                    <div class="meta">
<?php echo ViewHelper::formatDate($event['start_date']) ?> - <?php echo ViewHelper::formatDate($event['end_date']) ?> <br />
                        <?php echo $event['location'] ?><br />
                        <a href="#" class="btn small">I'm attending</a> &nbsp; <strong><?php echo $event['total_attending'] ?> people</strong> attending so far!
                    </div>
                </div>

            </div>

            <p class="align-justify"><?php echo nl2br($event['summary']) ?></p>
            <p><strong>Event Link:</strong> <br /><a href="<?php echo $event['href'] ?>"><?php echo $event['href'] ?></a></p>

            <h3>Talks</h3>
            <ul>
                <?php foreach ($talks as $talk): ?>
                    <li><a href="<?php ViewHelper::url('?page=talk&id=' . $talk['talk_id']) ?>"><?php echo $talk['title'] ?></a></li>
                <?php endforeach; ?>
            </ul>
            
            <h3>Comments</h3>
            <div class="comments" id="comments">
                <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="meta"><strong><?php echo empty($comment['name']) ? $comment['email'] : $comment['name'] ?></strong> on <em><?php echo ViewHelper::formatDate($comment['create_date']) ?></em> said:</div>
                    <?php echo nl2br($comment['body']) ?>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="post-comment">

                <h4>Write a comment:</h4>
                <form action="<?php ViewHelper::url('?page=comment') ?>" class="form-stacked" method="post">

                    <textarea class="xxlarge" id="comment" name="body" rows="7" cols="50"></textarea>
                    <span class="help-block">Please be polite in your comment as this is a social site.</span> <br />

                    <input type="hidden" value="<?php echo $event['event_id'] ?>" name="event_id" />
                    <input type="submit" class="btn primary" value="Submit" />

                </form>

            </div>

        </div>

        <div class="span4">

            <div class="widget">

                <h4>Categories</h4>

                <ul>
<?php foreach ($categories as $category): ?>
                        <li><a href="<?php ViewHelper::url('?page=cat&id=' . $category['category_id']) ?>"><?php echo $category['title'] ?></a></li>
                    <?php endforeach; ?>
                </ul>

            </div>

            <div class="widget">

                <h4>Submit your event</h4>

                <p>Arranging an event that is not listed here? Let us know! We love to get the word out about events the community would be interested in.</p>
                <p style="text-align: center;"><a href="<?php ViewHelper::url('?page=add-event') ?>" class="btn success">Submit your event!</a></p>


            </div>

        </div>

    </div>

</div>

<?php include_once 'footer.php'; ?>