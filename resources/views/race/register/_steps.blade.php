<?php
function write_class($i, $active, $has_error, $user_progress) {
    if($i == $active) {
        echo ' active';
    }
    if($has_error) {
        echo ' has-error';
    }
    if($user_progress < $i || ($user_progress == 5 && $i < 5)) {
        echo ' disabled';
    }
}
?>

<ul class="nav steps bg-light">
    <li class="nav-item">
        <a href="{{ route('race.register.step' . 1) }}" class="nav-link{{ write_class(1, $active, $has_error, $user_progress) }}">
            <span class="step-i">Étape 1</span>
            Capitaine de l'équipe
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('race.register.step' . 2) }}" class="nav-link{{ write_class(2, $active, $has_error, $user_progress) }}">
            <span class="step-i">Étape 2</span>
            Pilotes
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('race.register.step' . 3) }}" class="nav-link{{ write_class(3, $active, $has_error, $user_progress) }}">
            <span class="step-i">Étape 3</span>
            Caisses à savon
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('race.register.step' . 4) }}" class="nav-link{{ write_class(4, $active, $has_error, $user_progress) }}">
            <span class="step-i">Étape 4</span>
            Récapitulatif de l'équipe
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('race.register.step' . 5) }}" class="nav-link{{ write_class(5, $active, $has_error, $user_progress) }}">
            <span class="step-i">Étape 5</span>
            Paiement
        </a>
    </li>
</ul>