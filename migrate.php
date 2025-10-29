<?php
/**
 * migrate.php
 * Clones all tables from database `ctf` to `ctf2`
 * and applies schema fixes (foreign keys, indexes, timestamps).
 * 
 * Author: shettimax
 */

$srcDb = 'ctf';
$dstDb = 'ctf2';

// === CONFIG ===
$mysqli = new mysqli('127.0.0.1', 'root', 'kir@1337', '');
if ($mysqli->connect_error) {
    die("DB Connection failed: " . $mysqli->connect_error);
}

// Disable foreign key checks
$mysqli->query("SET FOREIGN_KEY_CHECKS=0;");

// 1️⃣ Drop all existing tables in target DB
$res = $mysqli->query("SELECT table_name FROM information_schema.tables WHERE table_schema='$dstDb'");
while ($row = $res->fetch_assoc()) {
    $t = $row['table_name'];
    echo "Dropping table $t...\n";
    $mysqli->query("DROP TABLE IF EXISTS `$dstDb`.`$t`");
}

// 2️⃣ Copy structure + data from source
$res = $mysqli->query("SELECT table_name FROM information_schema.tables WHERE table_schema='$srcDb'");
while ($row = $res->fetch_assoc()) {
    $t = $row['table_name'];
    echo "Copying $t...\n";
    $mysqli->query("CREATE TABLE `$dstDb`.`$t` LIKE `$srcDb`.`$t`");
    $mysqli->query("INSERT INTO `$dstDb`.`$t` SELECT * FROM `$srcDb`.`$t`");
}

// 3️⃣ Apply schema patches
echo "Applying schema fixes...\n";

// foreign keys + consistency
$patches = [

"ALTER TABLE `$dstDb`.`quiz`
 MODIFY COLUMN topic_id INT NOT NULL,
 ADD INDEX idx_topic_id (topic_id),
 ADD CONSTRAINT fk_quiz_topic FOREIGN KEY (topic_id)
 REFERENCES `$dstDb`.`quiztopic`(topic_id)
 ON DELETE CASCADE ON UPDATE CASCADE;",

"ALTER TABLE `$dstDb`.`quizquestions`
 MODIFY COLUMN quiz_id INT NOT NULL,
 ADD INDEX idx_quiz_id (quiz_id),
 ADD CONSTRAINT fk_question_quiz FOREIGN KEY (quiz_id)
 REFERENCES `$dstDb`.`quiz`(qid)
 ON DELETE CASCADE ON UPDATE CASCADE;",

"ALTER TABLE `$dstDb`.`quizsessions`
 MODIFY COLUMN topic_id INT NOT NULL,
 ADD INDEX idx_topic_id (topic_id),
 ADD CONSTRAINT fk_session_topic FOREIGN KEY (topic_id)
 REFERENCES `$dstDb`.`quiztopic`(topic_id)
 ON DELETE CASCADE ON UPDATE CASCADE;",

"ALTER TABLE `$dstDb`.`quizansweroptions`
 ADD CONSTRAINT fk_option_question FOREIGN KEY (question_id)
 REFERENCES `$dstDb`.`quizquestions`(id)
 ON DELETE CASCADE ON UPDATE CASCADE;",

// timestamps + audit
"ALTER TABLE `$dstDb`.`quizsessions`
 ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;",

"ALTER TABLE `$dstDb`.`quizattempts`
 ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;",

// indexes for lookup speed
"ALTER TABLE `$dstDb`.`quizattempts`
 ADD INDEX idx_ctfid (ctfid),
 ADD INDEX idx_question_id (question_id);",

// ensure auto_increment consistency
"ALTER TABLE `$dstDb`.`quiztopic` MODIFY COLUMN topic_id INT AUTO_INCREMENT;",
"ALTER TABLE `$dstDb`.`quiz` MODIFY COLUMN qid INT AUTO_INCREMENT;",
"ALTER TABLE `$dstDb`.`quizquestions` MODIFY COLUMN id INT AUTO_INCREMENT;",
"ALTER TABLE `$dstDb`.`quizansweroptions` MODIFY COLUMN id INT AUTO_INCREMENT;",
"ALTER TABLE `$dstDb`.`quizattempts` MODIFY COLUMN id INT AUTO_INCREMENT;",
"ALTER TABLE `$dstDb`.`quizsessions` MODIFY COLUMN id INT AUTO_INCREMENT;"
];

foreach ($patches as $sql) {
    if (!$mysqli->query($sql)) {
        echo "⚠️ Patch failed: " . $mysqli->error . "\nSQL: $sql\n";
    }
}

// 4️⃣ Re-enable foreign keys
$mysqli->query("SET FOREIGN_KEY_CHECKS=1;");

echo "\n✅ Migration complete!\n";
$mysqli->close();
