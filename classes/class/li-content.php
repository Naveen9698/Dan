.li-symbol, .li-img {
  list-style:none;
}

.li-symbol li::before {
  content:var(--li-symbol);
  margin-right:10px;
}


.li-img li::before {
  content:var(--li-img);
  margin-right:10px;
}