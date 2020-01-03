<?php
if (isset($_GET["category"])) {
    $categoryId = $_GET["category"];

    $category = getCategory($categoryId);

    if ($category->num_rows > 0) {
        $rowCategory = $category->fetch_assoc();
    }

    if (isset($_POST["edit-category"])) {
        $categoryName = $_POST["edit-category-name"];
        if (!existCategory($categoryName)) {
            editCategory($categoryId, $categoryName);
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Kategorie byla upravena.</p>
                    </div>    
                </div>
            </div>   
            ");
            header("Refresh:1; url=?page=manage_data");
        } else {
            echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Kategorie již existuje.</p>
                    </div>    
                </div>
            </div>   
            ");
        }
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div class="message-form">
                <form action="" method="post">
                    <label>Název kategorie<input type="text" placeholder="Název nového kraje" name="edit-category-name" required value="<?php
                        echo $rowCategory["name"];
                        ?>"></label>
                    <input type="submit" name="edit-category" value="Editovat kategorii">
                </form>
            </div>
        </div>
    </div>
</div>

