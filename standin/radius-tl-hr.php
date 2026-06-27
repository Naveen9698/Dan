.rtl-xxs { border-top-left-radius: var(--ra-xxs); }
.rtl-xs  { border-top-left-radius: var(--ra-xs);  }
.rtl-sm  { border-top-left-radius: var(--ra-sm);  }
.rtl-md  { border-top-left-radius: var(--ra-md);  }
.rtl-lg  { border-top-left-radius: var(--ra-lg);  }
.rtl-xl  { border-top-left-radius: var(--ra-xl);  }
.rtl-xxl { border-top-left-radius: var(--ra-xxl); }
.rtl-0   { border-top-left-radius: 0;             }

[class^="hr-rtl-"]:hover,
[class*=" hr-rtl-"]:hover,
.chr-parent:hover [class^="hr-rtl-"]:hover,
.chr-parent:hover [class*=" hr-rtl-"]:hover,
.chr-parent:hover [class^="chr-rtl-"],
.chr-parent:hover [class*=" chr-rtl-"] {
  border-top-left-radius: var(--rtl-val);
}

.hr-rtl-xxs, .chr-rtl-xxs { --rtl-val: var(--ra-xxs); }
.hr-rtl-xs,  .chr-rtl-xs  { --rtl-val: var(--ra-xs);  }
.hr-rtl-sm,  .chr-rtl-sm  { --rtl-val: var(--ra-sm);  }
.hr-rtl-md,  .chr-rtl-md  { --rtl-val: var(--ra-md);  }
.hr-rtl-lg,  .chr-rtl-lg  { --rtl-val: var(--ra-lg);  }
.hr-rtl-xl,  .chr-rtl-xl  { --rtl-val: var(--ra-xl);  }
.hr-rtl-xxl, .chr-rtl-xxl { --rtl-val: var(--ra-xxl); }
.hr-rtl-0,   .chr-rtl-0   { --rtl-val: 0;             }