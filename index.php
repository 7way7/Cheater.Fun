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

    // Extract 'id' column from $blogPosts array
    $ids = array_column($blogPosts, 'id');

    // Sort $blogPosts array based on 'id' column
    array_multisort($ids, SORT_ASC, $blogPosts);

    return $blogPosts;
}



// Function to get a subset of blog posts based on the current page
function getBlogPostsForPage($allBlogPosts, $currentPage, $blogsPerPage) {
    $startIndex = ($currentPage - 1) * $blogsPerPage;
    return array_slice($allBlogPosts, $startIndex, $blogsPerPage);
}

// Set the number of blogs to display per page
$blogsPerPage = 10;

// Retrieve all blog posts
$allBlogPosts = getAllBlogPosts();

// Get the current page from the URL
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Get a subset of blog posts for the current page
$blogPostsForPage = getBlogPostsForPage($allBlogPosts, $currentPage, $blogsPerPage);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacks.fun - Blogs</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1><a class="Header" href="index.php">Cheater.fun</a></h1>
        <nav>
            <a href="index.php" onclick="showSection('mainContent')">Main</a>
            <a href="blogs.php" onclick="showSection('blogsContent')">Blogs</a>
            <a href="tags.php" onclick="showSection('tagsContent')">Tags</a>
            <a href="about.php" onclick="showSection('aboutContent')">About</a>
        </nav>
    </header>

    <main>
    <section id="blogsContent">
        <h2>Blogs</h2>

        <!-- Display Blogs with Images -->
        <?php foreach ($blogPostsForPage as $blogPost): ?>
            <div class="blogPost">
                <?php if (!empty($blogPost['image'])): ?>
                    <!-- Display image from the provided link -->
                    <img class="blogImage" src="<?= htmlspecialchars($blogPost['image']) ?>" alt="Blog Image">
                <?php endif; ?>
                <div class="blogContent">
                    <!-- Make the blog title clickable -->
                    <h3 class="blogTitle"><a href="blog_details.php?id=<?= $blogPost['id'] ?>"><?php echo htmlspecialchars($blogPost['title']) ?></a></h3>
                    <h4 class="blogCreator">Made by: <span class="creatorName"><?= htmlspecialchars($blogPost['creator']) ?></span></h4>
                    <h5 class="blogTime">Time : <span class="time"><?= htmlspecialchars($blogPost['time']) ?></span></h5>
                    <h6 class="blogStatue">Statue : <span class="Statue"><?= htmlspecialchars($blogPost['status']) ?></span></h6>
                </div>
            </div>
        <?php endforeach; ?>

    </section>
    <!-- Pagination Links -->
     <div class="pagination" style="margin-top: -59px;margin-bottom: 40px;">
            <?php
            // Calculate the total number of pages
            $totalPages = ceil(count($allBlogPosts) / $blogsPerPage);

            // Display pagination links
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="index.php?page=' . $i . '">' . $i . '</a>';
            }
            ?>
        </div>
        
</main>


    <footer>
        <p>Hacks.fun @Made by Issam Bealaychi</p>
    </footer>
</body>
</html>
