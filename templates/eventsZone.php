<!-- MAIN -->
<main>
    <div class="container fluid my-5">
        <div class="row">

            <div class="col-md-2 categories-container">
                <h2>Categorías</h2>

                Mostrar todos <input type="checkbox" class="ms-2 form-check-input show-all">

                <?php
                    foreach ($categories as $category)
                    {
                        echo "<div class='category shadow mt-2 p-2' data-id='{$category->__get("id")}'>{$category->__get("name")}</div>";
                    } 
                ?>
            </div>

            <div class="col-md-10 events-container"></div>
        </div>
    </div>
</main>