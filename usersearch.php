<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
                <h3>Search Users</h3>

                <form class="form-horizontal" role="form" action="usersearch.php" method="post" name="main_login">
                  <div class="form-group">
                    <label for="search" class="col-sm-2 control-label">Search</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="search" name="search" placeholder="Search...">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4">
                      <button type="submit" class="btn btn-default" value="Search">Search</button>
                    </div>
                  </div>
                </form>

        <?php
        if (isset($_POST['search'])) {
                if(preg_match("/[A-Z|a-z]+/", $_POST['search'])){
                    $search = $_POST['search'];

                    $stmt = $pdo->prepare("SELECT m.id, m.username, m.is_premium, c.name as clan, g.name as guild
                                           FROM members AS m
                                           JOIN clans AS c ON c.id = m.clan_id
                                           LEFT JOIN guilds AS g ON g.id = m.guild_id
                                           WHERE m.username LIKE :search OR
                                                 m.forename LIKE :search OR
                                                 m.surname LIKE :search");
                    $stmt->execute(array(':search' => '%'.$search.'%'));

                    if ($stmt->rowcount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          if($row['guild'] == NULL) {
                            $guild = 'No Guild';
                          } else {
                            $guild = $row['guild'];
                          }
                            ?>
                            <dt><a href="user.php?user=<?php echo $row['id']; ?>"><?php echo $row['username']; ?></a> - <?php echo $row['clan']; ?> - <?php echo $guild; ?></dt>
                            <?php
                        }
                    } else {
                        echo 'There were no results for "' . $search . '"';
                    }
                } else {
                    echo 'Please enter a search term.';
                }
        }
        ?>

            <p>Return to <a href="login.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
            </p>
        <?php endif; ?>
    </div>
    </body>
</html>