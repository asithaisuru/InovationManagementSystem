<?php
session_start();

// Check if the user is logged in and has the required role
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator' && $role != 'Supplier' && $role != 'Buyer') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

// Include db connection
include '../dbconnection.php';

// Get the offset value from the URL parameter
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// SQL query to fetch posts with the given offset
$sql = "SELECT * FROM posts ORDER BY date DESC LIMIT 8 OFFSET ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $offset);
$stmt->execute();
$result = $stmt->get_result();

// Check if any posts are found
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if the current user has liked this post
        $postid = $row['postid'];
        $likedQuery = "SELECT * FROM post_likes WHERE post_id=? AND user_id=?";
        $likedStmt = $connection->prepare($likedQuery);
        $likedStmt->bind_param("ss", $postid, $username);
        $likedStmt->execute();
        $likedResult = $likedStmt->get_result();
        $isLiked = ($likedResult->num_rows > 0);

        // Get the number of likes for this post
        $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id=?";
        $likeCountStmt = $connection->prepare($likeCountQuery);
        $likeCountStmt->bind_param("s", $postid);
        $likeCountStmt->execute();
        $likeCountResult = $likeCountStmt->get_result();
        $likeCountRow = $likeCountResult->fetch_assoc();
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
        echo "<button class='btn btn-sm " . ($isLiked ? "btn-success" : "btn-primary") . " like-btn' data-post-id='" . htmlspecialchars($postid) . "' style='width: 55px; margin-top: 5px;'>" . ($isLiked ? "Liked" : "Like") . "</button>";
        echo "<span class='mt-2 ms-2 me-1 like-count .text-white fw-bold' data-post-id='" . htmlspecialchars($postid) . "'>$likeCount</span>";
        echo "<span class='mt-1 ms-0.3 me-2 like-icon animate_animated animate_bounce'><i class='fas fa-thumbs-up .text-white fs-6'></i></span>";
        echo "</div>";

        $interests = [];
        if ($role == 'Buyer') {
            echo "<button class='btn " . (in_array($row['postid'], $interests) ? "btn-success" : "btn-primary") . " add-to-interests-btn mt-2 ms-0.1 me-1' data-post-id='" . $row['postid'] . "' style='width: 200px; height: 35px; font-size: 15px;'>" . (in_array($row['postid'], $interests) ? "Already in your interests" : "Add to Interests") . "</button>";
        }

        echo "</div>";
    }
} else {
    echo "<div class='alert alert-warning text-center'>No more posts to show</div>";
}
?>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// Function to add event listeners to "Add to Interests" buttons
function addInterestsButtonListeners() {
    const addToInterestsButtons = document.querySelectorAll('.add-to-interests-btn');

    addToInterestsButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const btn = this;

            fetch('add_to_interests.php', {
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
}

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
        if (data !== 'success') {
            console.error('Failed to update buyer_interests table.');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Function to retrieve the state of the button from the buyer_interests table
function getBuyerInterests(postId) {
    return fetch('get_buyer_interests.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'post_id=' + postId
    })
    .then(response => response.json())
    .then(data => data.state)
    .catch(error => console.error('Error:', error));
}

// Call the function to add event listeners when the page loads
document.addEventListener('DOMContentLoaded', () => {
    addLikeButtonListeners();
    addInterestsButtonListeners();
});
</script>