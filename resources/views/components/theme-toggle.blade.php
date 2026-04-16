<label class="ts" aria-label="Changer le thème">
    {{-- 1. Le Checkbox (placé en premier pour le CSS, mais affiché au milieu grâce à Flexbox) --}}
    <input id="theme-toggle" class="ts__input" type="checkbox" role="switch" />

    {{-- 2. Icône Soleil --}}
    <span class="ts__icon ts__icon--light">
        <span class="ts__p ts__p--1"></span>
        <span class="ts__p ts__p--2"></span>
        <span class="ts__p ts__p--3"></span>
        <span class="ts__p ts__p--4"></span>
        <span class="ts__p ts__p--5"></span>
        <span class="ts__p ts__p--6"></span>
        <span class="ts__p ts__p--7"></span>
        <span class="ts__p ts__p--8"></span>
        <span class="ts__p ts__p--9"></span>
    </span>

    {{-- 3. Icône Lune (Pur CSS) --}}
    <span class="ts__icon ts__icon--dark">
        <span class="ts__p ts__p--moon"></span>
        <span class="ts__p ts__p--star ts__p--star-1"></span>
        <span class="ts__p ts__p--star ts__p--star-2"></span>
        <span class="ts__p ts__p--star ts__p--star-3"></span>
    </span>

    <span class="ts__label">Dark Mode</span>
</label>

<style>
.ts, .ts__input { -webkit-tap-highlight-color: transparent; }

.ts {
    --h: 30;
    --dur: 0.3s;
    --lsh: hsla(var(--h),10%,95%,0.5);
    --dsh: hsla(var(--h),10%,15%,0.4);
    --pri: var(--orange, #F97316);
    --pri-t: hsla(30,90%,50%,0);
    --bg-ts: var(--dark, #FAFAFA);
    font-size: 22px;
    display: flex;
    gap: 0.5em;
    align-items: center;
    cursor: pointer;
}

/* ── Ordre d'affichage Flexbox ── */
.ts__icon--light { order: 1; }
.ts__input       { order: 2; }
.ts__icon--dark  { order: 3; }

.ts__icon, .ts__p { display: block; }

.ts__icon {
    position: relative;
    width: 1em; height: 1em;
    transition: filter var(--dur);
}
.ts__p {
    background-color: hsla(var(--h),10%,10%,0.3);
    position: absolute;
    transition: background-color var(--dur), box-shadow var(--dur);
}

/* ── Soleil ── */
.ts__icon--light {
    filter: drop-shadow(0 0 0.125em hsla(var(--h),90%,70%,0.2));
}
.ts__icon--light .ts__p {
    background-color: hsla(var(--h),90%,70%,1);
    border-radius: 0.125em;
    top: 50%; left: 50%;
    width: 0.125em; height: 0.2em;
    transform-origin: 50% 0;
}
.ts__icon--light .ts__p--1 {
    border-radius: 50%;
    box-shadow: 0 0.0625em 0.0625em var(--dsh) inset, 0 0.0625em 0.0625em var(--lsh);
    top: 0.3em; left: 0.3em;
    width: 0.4em; height: 0.4em;
}
.ts__icon--light .ts__p--2  { box-shadow: 0 0.0625em 0.0625em var(--dsh) inset, 0 0.0625em 0.0625em var(--lsh); transform: translateX(-50%) rotate(0deg) translateY(0.3em); }
.ts__icon--light .ts__p--3  { box-shadow: 0.0625em 0.0625em 0.0625em var(--dsh) inset, 0.0625em 0.0625em 0.0625em var(--lsh); transform: translateX(-50%) rotate(45deg) translateY(0.3em); }
.ts__icon--light .ts__p--4  { box-shadow: 0.0625em 0 0.0625em var(--dsh) inset, 0.0625em 0 0.0625em var(--lsh); transform: translateX(-50%) rotate(90deg) translateY(0.3em); }
.ts__icon--light .ts__p--5  { box-shadow: 0.0625em -0.0625em 0.0625em var(--dsh) inset, 0.0625em -0.0625em 0.0625em var(--lsh); transform: translateX(-50%) rotate(135deg) translateY(0.3em); }
.ts__icon--light .ts__p--6  { box-shadow: 0 -0.0625em 0.0625em var(--dsh) inset, 0 -0.0625em 0.0625em var(--lsh); transform: translateX(-50%) rotate(180deg) translateY(0.3em); }
.ts__icon--light .ts__p--7  { box-shadow: -0.0625em -0.0625em 0.0625em var(--dsh) inset, -0.0625em -0.0625em 0.0625em var(--lsh); transform: translateX(-50%) rotate(225deg) translateY(0.3em); }
.ts__icon--light .ts__p--8  { box-shadow: -0.0625em 0 0.0625em var(--dsh) inset, -0.0625em 0 0.0625em var(--lsh); transform: translateX(-50%) rotate(270deg) translateY(0.3em); }
.ts__icon--light .ts__p--9  { box-shadow: -0.0625em 0.0625em 0.0625em var(--dsh) inset, -0.0625em 0.0625em 0.0625em var(--lsh); transform: translateX(-50%) rotate(315deg) translateY(0.3em); }

/* ── Lune ── */
.ts__icon--dark {
    filter: drop-shadow(0 0 0.125em hsla(var(--h),90%,70%,0)) drop-shadow(0 0.0625em 0.0625em var(--lsh));
}

/* Croissant de lune redimensionné et plus affirmé */
.ts__icon--dark .ts__p--moon {
    background-color: transparent;
    border-radius: 50%;
    /* Ombre interne plus prononcée pour un croissant plus épais */
    box-shadow: inset -0.28em -0.22em 0 0 hsla(var(--h),10%,10%,0.3);
    width: 0.85em;
    height: 0.85em;
    top: 0.05em;
    left: 0.05em;
    transition: box-shadow var(--dur);
}

/* Étoiles repositionnées pour la grande lune */
.ts__icon--dark .ts__p--star {
    background-color: hsla(var(--h),10%,10%,0.3);
    border-radius: 50%;
}
.ts__icon--dark .ts__p--star-1 { width: 0.15em; height: 0.15em; top: 0.1em; left: 0.7em; }
.ts__icon--dark .ts__p--star-2 { width: 0.1em; height: 0.1em; top: 0.45em; left: 0.85em; }
.ts__icon--dark .ts__p--star-3 { width: 0.12em; height: 0.12em; top: 0.8em; left: 0.6em; }


/* ── ANIMATIONS LORS DU CHANGEMENT DE THÈME ── */

/* 1. Le Soleil s'éteint (L'input précède le soleil, le ~ fonctionne !) */
.ts__input:checked ~ .ts__icon--light {
    filter: drop-shadow(0 0 0.125em hsla(var(--h),90%,75%,0));
}
.ts__input:checked ~ .ts__icon--light .ts__p {
    background-color: hsla(var(--h),10%,10%,0.3);
}

/* 2. La Lune s'allume avec un halo plus large */
.ts__input:checked ~ .ts__icon--dark {
    filter: drop-shadow(0 0 0.2em hsla(var(--h),90%,75%,0.6)) drop-shadow(0 0.0625em 0.0625em var(--lsh));
}
.ts__input:checked ~ .ts__icon--dark .ts__p--moon {
    box-shadow: inset -0.28em -0.22em 0 0 hsla(var(--h),90%,75%,1);
}
.ts__input:checked ~ .ts__icon--dark .ts__p--star {
    background-color: hsla(var(--h),90%,75%,1);
}

/* ── Track (Le Switch) ── */
.ts__input {
    background-color: hsla(var(--h),10%,10%,0.1);
    border-radius: 0.75em;
    box-shadow: 0 0.0625em 0.125em var(--dsh) inset, 0 0.0625em 0.125em var(--lsh), 0 0 0 0.125em var(--pri-t);
    display: block;
    outline: transparent;
    position: relative;
    width: 2.5em; height: 1.5em;
    transition: box-shadow var(--dur);
    -webkit-appearance: none;
    appearance: none;
    cursor: pointer;
}
.ts__input:focus-visible {
    box-shadow: 0 0.0625em 0.125em var(--dsh) inset, 0 0.0625em 0.125em var(--lsh), 0 0 0 0.125em var(--pri);
}
.ts__input:before {
    background-color: var(--pri);
    border-radius: 50%;
    box-shadow: 0 0.0625em 0.125em hsla(var(--h),10%,10%,0.5);
    content: "";
    display: block;
    position: absolute;
    top: 0.25em; left: 0.25em;
    width: 1em; height: 1em;
    transition: background-color var(--dur), transform var(--dur) cubic-bezier(0.65,0.05,0.34,1);
}
.ts__input:checked:before { transform: translateX(1em); }

/* ── Accessibilité ── */
.ts__label { overflow: hidden; position: absolute; width: 1px; height: 1px; }

</style>
