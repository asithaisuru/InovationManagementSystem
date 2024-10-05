<?php
require_once "../Classes/Innovator.php";
session_start();
// Check if the user is logged the required role
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator' && $role != 'Supplier' && $role != 'Buyer') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../sign-in.php");
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}
// Include db
include '../dbconnection.php';


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>Forum</title>
    <style>
        #backToTopBtn {
            display: none;
            /* Initially hide the button */
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            /* Ensure the button is above other elements */
        }
    </style>

</head>

<body class="bg-dark text-white">
    <!-- Include the nav bar -->
    <?php
    if ($role == 'Innovator')
        include '../Innovator/innovator-nav.php';
    elseif ($role == 'Supplier')
        include '../Supplier/supplier-nav.php';
    elseif ($role == 'Buyer')
        include '../Buyer/buyer-nav.php';
    ?>

    <body>

        <div class="container">
            <!-- Forum -->
            <h1 class="text-center animate__animated animate__zoomIn" data-mdb-animation-start="onLoad">Welcome to the
                Innovator Forum</h1>
            <p class="text-center animate__animated animate__zoomIn" data-mdb-animation-start="onLoad">A space for
                sharing success stories, seeking collaborators, and exchanging insights into the innovation process.</p>
            <div>
                <!-- Link story btn -->
                <div class="text-center">
                    <?php
                    if ($role != 'Buyer') {
                        echo "<a href='./submit-form.php' class='btn btn-success btn-lg animate__animated animate__zoomIn'>Create your story</a>";
                    }
                    ?>
                </div>
            </div> <br>
            <div class="card-body border-3 border-white bg-dark mb-3">
                <div class="card-body border-3 border-white bg-dark mb-3 animate__animated animate__zoomIn"
                    data-mdb-animation-start="onLoad">
                    <h4>Category</h4>
                    <form method="GET">
                        <!-- Dropdown categories -->
                        <select name="post_category" id="post_category" class="form-control" required
                            onchange="filterPosts(this.value)">
                            <option value="all">All</option>
                            <?php
                            // Define and display post categories
                            $categories = array(
                                'SuccessStories' => 'Success Stories',
                                'CollaborationOpportunities' => 'Collaboration Opportunities',
                                'InsightsandTips' => 'Insights and Tips',
                                'SkillsandQualifications' => 'Skills and Qualifications',
                                'PersonalBranding' => 'Personal Branding'
                            );
                            foreach ($categories as $value => $label) {
                                echo "<option value='$value'>$label</option>";
                            }
                            ?>
                        </select> </br>
                        <button class="btn btn-info animate__animated animate__zoomIn" type="submit">Search
                            Posts</button>
                    </form>
                </div>
                </form>

                <!-- Display Posts -->
                <div id="post-container">
                    <?php
                    // SQL query to fetch posts
                    $sql = "SELECT * FROM posts";
                    if (isset($_GET['post_category']) && $_GET['post_category'] != 'all') {
                        $category = mysqli_real_escape_string($connection, $_GET['post_category']);
                        $sql .= " WHERE category='$category'";
                    }
                    $sql .= " ORDER BY date DESC LIMIT 8";
                    $result = mysqli_query($connection, $sql);
                    // Check if any posts are found
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Check if the current user has liked this post
                            $postid = $row['postid'];
                            $likedQuery = "SELECT * FROM post_likes WHERE post_id='$postid' AND user_id='$username'";
                            $likedResult = mysqli_query($connection, $likedQuery);
                            $isLiked = (mysqli_num_rows($likedResult) > 0);

                            // Get the number of likes for this post
                            $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id='$postid'";
                            $likeCountResult = mysqli_query($connection, $likeCountQuery);
                            $likeCountRow = mysqli_fetch_assoc($likeCountResult);
                            $likeCount = $likeCountRow['like_count'];

                            // Display post details
                            echo "<div class='card bg-dark text-white border-1 border-white p-3 mb-3'>";
                            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                            echo "<p>" . htmlspecialchars($row['content']) . "</p>";
                            echo "<small>Posted by: <a class='text-white' href='../Innovator/view-profile.php?userName=" . htmlspecialchars($row['userName']) . "'>" . htmlspecialchars($row['userName']) . "</a></small>";
                            echo "<small>Posted on: " . (isset($row['date']) ? date('F j, Y', strtotime($row['date'])) : date('F j, Y')) . "</small>";
                            echo "<small>Posted at: <span id='post-time'>" . (isset($row['date']) ? date('h:i A', strtotime($row['date'])) : date('h:i A', time())) . "</span></small>";
                            echo "<small>Category: " . htmlspecialchars($row['category']) . "</small>";
                            echo "<div class='d-flex align-items-center'>";
                            echo "<button class='btn btn-sm " . ($isLiked ? "btn-success" : "btn-primary") . " like-btn animate__animated animate__zoomIn' data-post-id='" . htmlspecialchars($postid) . "' style='width: 55px; margin-top: 5px;' onclick='this.classList.add(\"animate__pulse\")' data-mdb-animation-start='onHover'>" . ($isLiked ? "Liked" : "Like") . "</button>";
                            echo "<span class='mt-2 ms-2 me-1 like-count .text-white fw-bold animate__animated animate__zoomIn' data-post-id='" . htmlspecialchars($postid) . "' data-mdb-animation-start='onLoad'>$likeCount</span>";
                            echo "<span class='mt-1 ms-0.3 me-2 like-icon animate__animated animate__bounce'><i class='fas fa-thumbs-up .text-white fs-6'></i></span>";
                            echo "</div>";


                            $interests = [];
                            if ($role == 'Buyer') {
                                echo "<button class='btn " . (in_array($row['postid'], $interests) ? "btn-success" : "btn-primary") . " add-to-interests-btn mt-2 ms-0.1 me-1' data-post-id='" . $row['postid'] . "' style='width: 200px; height: 35px; font-size: 15px;'>" . (in_array($row['postid'], $interests) ? "Already in your interests" : "Add to Interests") . "</button>";
                            }




                            echo "</div>";
                        }
                    } else {
                        // No posts found
                    }
                    ?>
                </div>
                <div class="text-center">
                    <button id="loadMoreBtn" class="btn btn-primary">Load More</button>
                </div>


                <!-- Include jQuery and Bootstrap JS -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 m-3">

            <!-- Back to Top Button -->
            <button id="backToTopBtn" class="btn btn-success rounded-circle p-3" type="submit">Top</button>
            <!-- Custom JS -->
            <script>
                // Show the button scrolls down 450 pixels
                window.onscroll = function () {
                    scrollFunction();
                };

                function scrollFunction() {
                    if (document.body.scrollTop > 450 || document.documentElement.scrollTop > 450) {
                        document.getElementById("backToTopBtn").style.display = "block";
                    } else {
                        document.getElementById("backToTopBtn").style.display = "none";
                    }
                }

                // Smooth scroll to top when the button is clicked
                document.getElementById('backToTopBtn').addEventListener('click', function () {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                // Function to add event listeners to like buttons
                function addLikeButtonListeners() {
                    const likeButtons = document.querySelectorAll('.like-btn');
                    likeButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const postid = this.getAttribute('data-post-id');
                            const btn = this;
                            // Send POST request to like post
                            fetch('like_post.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: 'postid=' + postid
                            })
                                .then(response => response.text())
                                .then(data => {
                                    if (data === 'liked') {
                                        // Update button style & text (liked)
                                        btn.classList.remove('btn-primary');
                                        btn.classList.add('btn-success');
                                        btn.textContent = 'Liked';
                                        updateLikeCount(postid, 1);
                                    } else if (data === 'unliked') {
                                        // Update button style & text (unliked)
                                        btn.classList.remove('btn-success');
                                        btn.classList.add('btn-primary');
                                        btn.textContent = 'Like';
                                        updateLikeCount(postid, -1);
                                    } else if (data === 'already liked') {
                                        alert('You already liked this post.');
                                    } else {
                                        alert('An error occurred.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        });
                    });
                }


                // Initial call to add listeners to the initially loaded posts
                addLikeButtonListeners();



                // Function to update the like count in real-time
                function updateLikeCount(postid, change) {
                    const likeCountElement = document.querySelector(`.like-count[data-post-id='${postid}']`);
                    const currentCount = parseInt(likeCountElement.textContent);
                    likeCountElement.textContent = currentCount + change;
                }

                // Load more posts functionality
                let offset = 8; // Number of posts initially loaded
                document.getElementById('loadMoreBtn').addEventListener('click', function () {
                    fetch(`load_more_posts.php?offset=${offset}`)
                        .then(response => response.text())
                        .then(data => {
                            const postContainer = document.getElementById('post-container');
                            if (data === "<div class='alert alert-warning text-center'>No more posts to show</div>") {
                                document.getElementById('loadMoreBtn').style.display = 'none';
                            }
                            postContainer.innerHTML += data;
                            offset += 8;
                            addLikeButtonListeners(); // Re-add event listeners to new like buttons
                            addInterestsButtonListeners(); // Add event listeners to new add to interests buttons
                        })
                        .catch(error => console.error('Error:', error));
                });
            </script>

            <!-- Handle form submission to add to interests -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const addToInterestsButtons = document.querySelectorAll('.add-to-interests-btn');

                    addToInterestsButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const postId = this.getAttribute('data-post-id');
                            const btn = this;

                            fetch('../buyer/add_to_interests.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: 'post_id=' + postId
                            })
                                .then(response => response.text())
                                .then(data => {
                                    if (data === 'added') {
                                        btn.classList.remove('btn-primary');
                                        btn.classList.add('btn-success');
                                        btn.textContent = 'Already in your interests';
                                        updateBuyerInterests(postId, 'added');
                                        // Store the state in local storage
                                        localStorage.setItem('buttonState_' + postId, 'added');
                                    } else if (data === 'already') {
                                        alert('This post is already in your interests.');
                                    } else {
                                        alert('Failed to add post to interests.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        });

                        // Retrieve the state of the button from the buyer_interests table on page load
                        const postId = button.getAttribute('data-post-id');
                        const storedState = localStorage.getItem('buttonState_' + postId);
                        if (storedState === 'added') {
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-success');
                            button.textContent = 'Already in your interests';
                        } else {
                            // Retrieve the state from the server if not stored in local storage
                            getBuyerInterests(postId).then(state => {
                                if (state === 'added') {
                                    button.classList.remove('btn-primary');
                                    button.classList.add('btn-success');
                                    button.textContent = 'Already in your interests';
                                    // Store the state in local storage
                                    localStorage.setItem('buttonState_' + postId, 'added');
                                }
                            });
                        }
                    });
                });

                // Function to update the buyer_interests table in the database
                function updateBuyerInterests(postId, state) {
                    fetch('update_buyer_interests.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'post_id=' + postId + '&state=' + state
                    })
                        .then(response => response.text())
                        .then(data => {
                            // Handle response if needed
                        })
                        .catch(error => console.error('Error:', error));
                }

                // Function to get the state of the button from the buyer_interests table in the database
                function getBuyerInterests(postId) {
                    return fetch('get_buyer_interests.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'post_id=' + postId
                    })
                        .then(response => response.text())
                        .then(data => data)
                        .catch(error => console.error('Error:', error));
                }
            </script>

            <!-- Include jQuery additional functionality -->
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        </div>

        <div id="footer">
            <!-- footer -->
            <?php include '../footer.php' ?>
        </div>


    </body>

</html>