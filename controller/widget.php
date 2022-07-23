<?php

$scanwidget = scandir("widgets/");

foreach ($scanwidget as $fichier) {


    if (!in_array($fichier, array(".", "..", "..."))) {
        if (file_exists("widgets/" . $fichier . "/info.yml") and file_exists("widgets/" . $fichier . "/code.php")) {

            $_widgetinfo_ = new Read("widgets/" . $fichier . "/info.yml");
            $_widgetinfo_ = $_widgetinfo_->GetTableau();

            $_widgetstatus_ = new Read("widgets/" . $fichier . "/status.yml");
            $_widgetstatus_ = $_widgetstatus_->GetTableau();

            if ($_widgetstatus_['enabled'] == 'true') {
                if ($_widgetinfo_['Informations']['display'] == 'true') {

?>


                    <div class="card mb-3">
                        <div class="card-header <?php echo "text-" . $_ThemeOption_['Personnalisation']['text_image_color'] . ""; ?>" style="background-image: url('<?php echo $_ThemeOption_['Personnalisation']['background_img']; ?>'); background-size: cover;">
                            <div class="row no-gutters align-items-center w-100">
                                <div class="col font-weight-bold pl-3 text-center"><b><?php echo strtoupper($_widgetinfo_['Informations']['name']); ?></b></div>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <?php include("widgets/" . $fichier . "/code.php"); ?>
                        </div>
                    </div>

<?php }
            }
        }
    }
} ?>