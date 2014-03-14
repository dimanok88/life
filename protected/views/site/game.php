<?
$this->title = "Игра сумма";
$this->pageDesc= "Легкая игра сумма чисел. В игре необходимо на каждом шаге выбирать числа, в сумме дающие случайно выпавшее число \"Сумма\", если сумма выбранных чисел совпадает со случайным числом, то они закрываются. По возможности необходимо закрыть все числа.";
?>
<div class="full_desc">
Легкая игра сумма чисел. В игре необходимо на каждом шаге выбирать числа, в сумме дающие случайно выпавшее число "Сумма", если сумма выбранных чисел совпадает со случайным числом, то они закрываются. По возможности необходимо закрыть все числа.
</div>
<br/>
<br/>
<div id="container_game">
        <div id="pick">
            Сетка: &nbsp;
            <select id="cbdim" class="btn-small" style="font-size:18px;">
                <option value="3">3 x 3</option>
                <option value="4">4 x 4</option>
                <option value="5">5 x 5</option>
                <option value="6">6 x 6</option>
                <option value="7">7 x 7</option>
            </select>
            <button id="btnstart" class="btn-small" onclick="start();">Начать игру!</button>
        </div>
        <p id="pnext">Сумма: &nbsp;<span id="nextsum">0</span></p>

        <div id="dimcontainer">
            <div id="boxclear" style="clear:both"></div>
        </div>
    </div>
