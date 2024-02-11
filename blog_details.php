<?php
// Function to get all blog posts from JSON files
function getAllBlogPosts() {
    $blogPosts = [];

    $files = glob('blog_posts/*.json');

    foreach ($files as $file) {
        $jsonContent = file_get_contents($file);
        $data = json_decode($jsonContent, true);

        if ($data) {
            $blogPosts[] = $data;
        }
    }

    return $blogPosts;
}

// Retrieve all blog posts
$allBlogPosts = getAllBlogPosts();
function getBlogPostById($postId) {
    // Assuming you have a function or method to fetch blog posts from storage
    // For example, reading from JSON files
    $allBlogPosts = getAllBlogPosts();
    $postId = intval($postId);

    // Iterate through all blog posts to find the one with the matching ID
    foreach ($allBlogPosts as $blogPost) {
        if ($blogPost['id'] === $postId) {
            return $blogPost; // Found the matching blog post
        }
    }

    return null; // Blog post with the given ID not found
}

// Retrieve blog post ID from the URL parameter
$blogPostId = isset($_GET['id']) ? $_GET['id'] : null;
// Retrieve the specific blog post data based on $blogPostId
$blogPost = getBlogPostById($blogPostId);

// Check if the blog post data is found
if ($blogPost === null) {
    var_dump($blogPostId);
    var_dump($allBlogPosts);
    // Handle case where the blog post with the given ID is not found
    header('Location: error.php');
     // Redirect to an error page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($blogPost['title']) ?> - Cheater.fun</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js" defer></script>
    <style>
 /* Add this style to your existing stylesheet or in the head of your HTML document */
 #blogDetailsContent .blogPost {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    #blogDetailsContent .blogInfo {
        text-align: left;
        margin-bottom: 10px;
    }

    #blogDetailsContent .blogImage2 img {
        width: 720px; /* Make the image fill its container */
        height: auto; /* Maintain aspect ratio */
        margin-bottom: 12px;
        object-fit: cover;
        border-radius: 4px;
    }

    #blogDetailsContent .blogText {
        max-width: 800px; /* Set a maximum width for the text */
        text-align: left; 
        white-space: pre-line;/* Adjust text alignment as needed */
    }
    #blogDetailsContent .bloglink {

    }
    .blogInfo {
        display: flex;
        justify-content: space-between;
        color: #888; /* Gray color */
        margin-bottom: 15px;
    }

    .blogInfo .ul1 {
        width: 340px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .blogInfo .ul2 {
        width: 150px;
        list-style: none;
        padding: 0;
        margin: 0;
    }


    .blogInfo li {
        margin-bottom: 8px;
    }

    .infoLabel {
        font-weight: bold;
    }

    .infoValue {
        color: #888;
    }


    </style>
</head>
<body>
<header>
        <h1><a href="main.php">Cheater.fun</a></h1>
        <nav>
            <a href="index.php" onclick="showSection('mainContent')">Main</a>
            <a href="blogs.php" onclick="showSection('blogsContent')">Blogs</a>
            <a href="tags.php" onclick="showSection('tagsContent')">Tags</a>
            <a href="about.php" onclick="showSection('aboutContent')">About</a>
        </nav>
    </header>

    <main>
    <section id="blogDetailsContent">
    <div class="blogPost">
        <div class="blogTitle">
            <h2><?= htmlspecialchars($blogPost['title']) ?></h2>
        </div>
        <div class="blogInfo">
    <ul class="ul1">
        <li><span class="infoLabel">Developer:</span> <span class="infoValue"><?= htmlspecialchars($blogPost['creator']) ?></span></li>
        <li><span class="infoLabel">Version:</span> <span class="infoValue"><?= htmlspecialchars($blogPost['version']) ?></span></li>
        <li><span class="infoLabel">Time:</span> <span class="infoValue"><?= htmlspecialchars($blogPost['time']) ?></span></li>
    </ul>
    <ul  class="ul2">
        <li><span class="infoLabel">Status:</span> <span class="infoValue"> <?= htmlspecialchars($blogPost['status']) ?></span></li>
        <li><span class="infoLabel">Game:</span> <span class="infoValue"> <?= htmlspecialchars($blogPost['tags']) ?></span></li>
    </ul>
</div>
        <div class="blogImage2">
            <img src="<?= htmlspecialchars($blogPost['image']) ?>" alt="Blog Image">
        </div>
        <div class="blogText">
            <li><?= htmlspecialchars($blogPost['text'] ?? '') ?></li>
        </div>
        <div class="blogLink">
    <!-- Display link -->
    <?php if (isset($blogPost['link']) && strpos($blogPost['link'], 'http://adfoc.us/') === 0): ?>
        <a href="<?= htmlspecialchars($blogPost['link']) ?>" target="_blank"><strong>+Download: <?= ($blogPost['link']) ?></strong></a>
    <?php else: ?>
        <span>+Direct Link: <strong><?= htmlspecialchars($blogPost['link'] ?? '') ?></strong></span>
    <?php endif; ?>
</div>


    </div>
</section>


    </main>

    <footer>
        <p>Cheater.fun @Made by Issam Bealaychi</p>
    </footer>
</body>
</html>

