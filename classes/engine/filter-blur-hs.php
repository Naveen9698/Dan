[class^="ho:blur-"]:hover, [class*=" ho:blur-"]:hover,
.cho-parent:hover [class^="ho:blur-"]:hover, .cho-parent:hover [class*=" ho:blur-"]:hover{
  --blur: var(--ho-blur);
}

.cho-parent:hover [class^="cho:blur-"], .cho-parent:hover [class*=" cho:blur-"]{
  --blur: var(--cho-blur);
}

[class^="cl:blur-"]:active, [class*=" cl:blur-"]:active,
.ccl-parent:active [class^="cl:blur-"]:active, .ccl-parent:active [class*=" cl:blur-"]:active{
  --blur: var(--cl-blur);
}

.ccl-parent:active [class^="ccl:blur-"], .ccl-parent:active [class*=" ccl:blur-"]{
  --blur: var(--ccl-blur);
}

.active[class^="ac:blur-"], .active[class*=" ac:blur-"],
.cac-parent.active .active[class^="ac:blur-"], .cac-parent.active .active[class*=" ac:blur-"]{
  --blur: var(--ac-blur);
}

.cac-parent.active [class^="cac:blur-"], .cac-parent.active [class*=" cac:blur-"]{
  --blur: var(--cac-blur);
}

.select[class^="sl:blur-"], .select[class*=" sl:blur-"],
.csl-parent.select .select[class^="sl:blur-"], .csl-parent.select .select[class*=" sl:blur-"]{
  --blur: var(--sl-blur);
}

.csl-parent.select [class^="csl:blur-"], .csl-parent.select [class*=" csl:blur-"]{
  --blur: var(--csl-blur);
}