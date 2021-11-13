<?php

                        echo "<form action='index.php' method='POST'>";
                        echo "<input type='hidden' name='IdCli' Value='$IdCli'>";
                        echo "<input type='hidden' name='IdUs' Value='$IdUs'>";
                        echo "<input type='hidden' name='Vendedor' Value='$NameUs'>";
                        echo "<input type='hidden' name='Cliente' Value='$NameCli'>";
                        echo "<input type='hidden' name='Barrio' Value='$Barrio'>";
                        echo "<input type='text' name='D14x5' placeholder='D14x5'>";
                        echo "<input type='text' name='D16x5' placeholder='D16x5'>";
                        echo "<input type='text' name='Minx20' placeholder='Minx20'>";
                        echo "<button type='submit' name='venta'> Enviar </button>";
                        echo "</form>";

?>