<?php

                        echo "<form action='index.php' method='POST'>";
                        echo "<input type='hidden' name='usuario' value='$UsuarioS'>";
                        echo "<input type='hidden' name='clave' value='$ClaveS'>";
                        echo "<input type='hidden' name='IdCli' Value='$IdCli'>";
                        echo "<input type='hidden' name='id_us' Value='$id_us'>";
                        echo "<input type='hidden' name='Vendedor' Value='$name_us'>";
                        echo "<input type='hidden' name='Cliente' Value='$NameCli'>";
                        echo "<input type='hidden' name='Barrio' Value='$Barrio'>";
                        echo "<input type='number' min='0' name='D14x5' placeholder='D14x5'>";
                        echo "<input type='number' min='0' name='D16x5' placeholder='D16x5'>";
                        echo "<input type='number' min='0' name='Minx20' placeholder='Minx20'>";
                        echo "<input type='number' min='0' name='masax1k' placeholder='Masax1K'>";
                        echo "<button type='submit' name='venta'> Enviar </button>";
                        echo "</form>";

?>