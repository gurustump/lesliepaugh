<?php

/*
 * Load defaults theme settings
 */

add_action('after_switch_theme', 'pxg_load_theme_defaults');

function pxg_load_theme_defaults(){


    $theme_options = get_option('senna_options');

    // Remember to encode in base64 if you want to change this default
    //George
    //$defaults = 'IyMjYTo1ODp7czo4OiJsYXN0X3RhYiI7czoxOiI0IjtzOjE3OiJ1c2Vfc21vb3RoX3Njcm9vbCI7czoxOiIxIjtzOjk6Im1haW5fbG9nbyI7czowOiIiO3M6MTY6InJldGluYV9tYWluX2xvZ28iO3M6MDoiIjtzOjc6ImZhdmljb24iO3M6MDoiIjtzOjE2OiJhcHBsZV90b3VjaF9pY29uIjtzOjA6IiI7czoxMDoibWV0cm9faWNvbiI7czowOiIiO3M6MTY6Imdvb2dsZV9hbmFseXRpY3MiO3M6MDoiIjtzOjEwOiJtYWluX2NvbG9yIjtzOjc6IiMwMWEyNzkiO3M6MTY6Imdvb2dsZV9tYWluX2ZvbnQiO3M6NToiQmlsYm8iO3M6MTA6ImN1c3RvbV9jc3MiO3M6MDoiIjtzOjk6ImN1c3RvbV9qcyI7czowOiIiO3M6MTI6ImhlYWRlcl9maXhlZCI7czoxOiIxIjtzOjE3OiJ1c2Vfc2l0ZV93aWRlX2JveCI7czoxOiIxIjtzOjE3OiJzaXRlX3dpZGVfc2VjdGlvbiI7czoxMDI6IjxoND5Vc2UgdGhpcyBzZWN0aW9uIHdpc2VseSBvciBoaWRlIGl0PC9oND4NCjxzbWFsbD5UaGlzIGlzIGEgc2l0ZS13aWRlIGNhbGwgdG8gYWN0aW9uIHNlY3Rpb248L3NtYWxsPiI7czoyMjoic2l0ZV93aWRlX2J1dHRvbl9sYWJlbCI7czoxNDoiQ2FsbCB0byBhY3Rpb24iO3M6MjE6InNpdGVfd2lkZV9idXR0b25fbGluayI7czoxOiIjIjtzOjE0OiJjb3B5cmlnaHRfdGV4dCI7czoxNDoiQ29weXJpZ2h0IDIwMTMiO3M6MTk6ImhvbWVwYWdlX3VzZV9zbGlkZXIiO3M6MToiMSI7czoxNzoiaG9tZXBhZ2VfY29udGVudDEiO3M6MjYzOiI8aDEgc3R5bGU9InRleHQtYWxpZ246IGNlbnRlcjsiPkNvbmdyYXR1bGF0aW9ucyE8L2gxPg0KPGgzIHN0eWxlPSJ0ZXh0LWFsaWduOiBjZW50ZXI7Ij5Zb3VyIHNpdGUgaXMganVzdCBhcm91bmQgdGhlIGNvcm5lci48L2gzPg0KJm5ic3A7DQo8cCBzdHlsZT0idGV4dC1hbGlnbjogY2VudGVyOyI+U3RhcnQgYnkgZ29pbmcgdG88c3Ryb25nPiBUaGVtZSBPcHRpb25zIC0gSG9tZSBQYWdlPC9zdHJvbmc+IHNlY3Rpb24gdG8gZWRpdCB0aGlzIGNvbnRlbnQuPC9wPiI7czoyMjoiaG9tZXBhZ2VfdXNlX3BvcnRmb2xpbyI7czoxOiIxIjtzOjE3OiJob21lcGFnZV9jb250ZW50MiI7czowOiIiO3M6MTY6ImNvbnRhY3RfdXNlX2dtYXAiO3M6MToiMSI7czoxNzoiY29udGFjdF9nbWFwX2xpbmsiO3M6ODg6Imh0dHBzOi8vbWFwcy5nb29nbGUuY29tL21hcHM/aGw9cm8mbGw9NTEuMzg0NTUxLC0yLjM2Mjc3NyZzcG49MC4wMjYxMTMsMC4wNjYwNDcmdD1tJno9MTUiO3M6MTM6ImNvbnRhY3RfcGhvbmUiO3M6MTU6IiszMDAyMyA2MzkgMzcxNCI7czoxMzoiY29udGFjdF9lbWFpbCI7czoyMjoiY29udGFjdEBwaXhlbGdyYWRlLmNvbSI7czoxNToiY29udGFjdF9hZGRyZXNzIjtzOjUzOiIxMTMzIEJyb2Fkd2F5LCBTdWl0ZSAxMTI0LCA8YnIgLz4gIE5ldyBZb3JrLCBOWSAxMDAxMCI7czoyMDoiY29udGFjdF9jb250ZW50X2xlZnQiO3M6NTI4OiI8aDE+SEVMTE8hIExFVOKAmVMgVEFMSy48L2gxPg0KSWYgeW91IHdvdWxkIGxpa2UgdG8gdGFsayB0byB1cyBhYm91dCBhIHByb2plY3Qgb3IgeW91IGhhdmUgYSBxdWVzdGlvbiwgcGxlYXNlIGdldCBpbiB0b3VjaC4gRmlsbCBpbiBvdXIgY29udGFjdCBmb3JtIGJlbG93IGFuZCB3ZeKAmWxsIGdldCByaWdodCBiYWNrIHRvIHlvdS4NCg0KV2hldGhlciB5b3UncmUgbG9va2luZyB0byBkaXNjdXNzIGEgbmV3IHByb2plY3Qgb3Igc2ltcGx5IHNheSBoZWxsbywgd2UnZCBsb3ZlIHRvIGhlYXIgZnJvbSB5b3UuDQoNCkdpdmUgdXMgYSBjYWxsLCBkcm9wIHVzIGFuIGVtYWlsIG9yIGNvbWUgcm91bmQgZm9yIGEgY2hhdC4NCg0KV2UncmUgYmFzZWQgcmlnaHQgaW4gdGhlIGNlbnRyZSBvZiBCYXRoIG9ubHkgYSAxNSBtaW51dGUgd2FsayBmcm9tIHRoZSB0cmFpbiBzdGF0aW9uLiBBbmQgdGhlcmUncyBhIGJpZyBjYXIgcGFyayBqdXN0IGFjcm9zcyBmcm9tIHRoZSBvZmZpY2UsIHNvIHdlJ3JlIHJlYWxseSBlYXN5IHRvIGdldCB0by4iO3M6MTg6ImNvbnRhY3RfZm9ybV90aXRsZSI7czoxNzoiU2VuZCBVcyBBIE1lc3NhZ2UiO3M6MTU6InBvcnRmb2xpb190aXRsZSI7czoxMzoiT3VyIFByb2plY3RzLiI7czoyMjoicG9ydGZvbGlvX2hlYWRlcl9pbWFnZSI7czowOiIiO3M6MjM6InBvcnRmb2xpb19hcmNoaXZlX2xpbWl0IjtzOjE6IjYiO3M6MjI6InBvcnRmb2xpb19zaW5nbGVfbGFiZWwiO3M6NzoiUHJvamVjdCI7czoyMjoicG9ydGZvbGlvX3BsdXJhbF9sYWJlbCI7czo4OiJQcm9qZWN0cyI7czoxNDoicG9ydGZvbGlvX3NsdWciO3M6MDoiIjtzOjIyOiJwb3J0Zm9saW9fYXJjaGl2ZV9zbHVnIjtzOjA6IiI7czoxNzoiYmxvZ19oZWFkZXJfaW1hZ2UiO3M6MDoiIjtzOjIxOiJibG9nX2FyY2hpdmVfdGVtcGxhdGUiO3M6NDoiZnVsbCI7czoxOToiYmxvZ19leGNlcnB0X2xlbmd0aCI7czoyOiI3NSI7czoyMDoiYmxvZ19zaW5nbGVfdGVtcGxhdGUiO3M6NDoiZnVsbCI7czoyODoiYmxvZ19zaW5nbGVfc2hvd19zaGFyZV9saW5rcyI7czoxOiIxIjtzOjIzOiJibG9nX3NpbmdsZV9zaG93X2F1dGhvciI7czoxOiIxIjtzOjI0OiJwcmVwYXJlX2Zvcl9zb2NpYWxfc2hhcmUiO3M6MToiMSI7czoxNToiZmFjZWJvb2tfaWRfYXBwIjtzOjA6IiI7czoxNzoiZmFjZWJvb2tfYWRtaW5faWQiO3M6MDoiIjtzOjE1OiJnb29nbGVfcGFnZV91cmwiO3M6MDoiIjtzOjE3OiJ0d2l0dGVyX2NhcmRfc2l0ZSI7czowOiIiO3M6MjY6InNvY2lhbF9zaGFyZV9kZWZhdWx0X2ltYWdlIjtzOjA6IiI7czoxMjoic29jaWFsX2ljb25zIjthOjExOntzOjU6ImdwbHVzIjtzOjY6Imdvb2dsZSI7czo4OiJmYWNlYm9vayI7czo4OiJmYWNlYm9vayI7czo3OiJ0d2l0dGVyIjtzOjc6InR3aXR0ZXIiO3M6ODoibGlua2VkaW4iO3M6ODoibGlua2VkaW4iO3M6NzoieW91dHViZSI7czo3OiJ5b3V0dWJlIjtzOjk6Imluc3RhZ3JhbSI7czowOiIiO3M6NToic2t5cGUiO3M6MDoiIjtzOjk6InBpbnRlcmVzdCI7czowOiIiO3M6NjoidHVtYmxyIjtzOjA6IiI7czo2OiJmbGlja3IiO3M6MDoiIjtzOjU6InZpbWVvIjtzOjA6IiI7fXM6MjU6InNvY2lhbF9pY29uc190YXJnZXRfYmxhbmsiO3M6MToiMSI7czoxNToidXNlX3JldGluYV9sb2dvIjtpOjA7czoxNjoidXNlX2dvb2dsZV9mb250cyI7aTowO3M6MjI6InBvcnRmb2xpb19yZXdyaXRlX3NsdWciO2k6MDtzOjMwOiJwb3J0Zm9saW9fcmV3cml0ZV9hcmNoaXZlX3NsdWciO2k6MDtzOjE4OiJwb3J0Zm9saW9fdXNlX3RhZ3MiO2k6MDtzOjI0OiJibG9nX3Nob3dfZmVhdHVyZWRfaW1hZ2UiO2k6MDtzOjMxOiJibG9nX3NpbmdsZV9zaG93X2NvbW1lbnRzX3RpdGxlIjtpOjA7czoxNzoicmVkdXgtb3B0cy1iYWNrdXAiO3M6MToiMSI7fSMjIw==';
    // Andrei
    $defaults = 'IyMjYTo2MTp7czo4OiJsYXN0X3RhYiI7czoxOiI5IjtzOjE3OiJ1c2Vfc21vb3RoX3Njcm9vbCI7czoxOiIxIjtzOjk6Im1haW5fbG9nbyI7czowOiIiO3M6MTY6InJldGluYV9tYWluX2xvZ28iO3M6MDoiIjtzOjc6ImZhdmljb24iO3M6MDoiIjtzOjE2OiJhcHBsZV90b3VjaF9pY29uIjtzOjA6IiI7czoxMDoibWV0cm9faWNvbiI7czowOiIiO3M6MTY6Imdvb2dsZV9hbmFseXRpY3MiO3M6MDoiIjtzOjEwOiJtYWluX2NvbG9yIjtzOjc6IiMwMWEyNzkiO3M6MTY6Imdvb2dsZV9tYWluX2ZvbnQiO3M6NToiQmlsYm8iO3M6MTk6ImJ3X3BvcnRmb2xpb19maWx0ZXIiO3M6MToiMSI7czoxMDoiY3VzdG9tX2NzcyI7czowOiIiO3M6OToiY3VzdG9tX2pzIjtzOjA6IiI7czoxMjoiaGVhZGVyX2ZpeGVkIjtzOjE6IjEiO3M6MTc6InVzZV9zaXRlX3dpZGVfYm94IjtzOjE6IjEiO3M6MTc6InNpdGVfd2lkZV9zZWN0aW9uIjtzOjEwMjoiPGg0PlVzZSB0aGlzIHNlY3Rpb24gd2lzZWx5IG9yIGhpZGUgaXQ8L2g0Pg0KPHNtYWxsPlRoaXMgaXMgYSBzaXRlLXdpZGUgY2FsbCB0byBhY3Rpb24gc2VjdGlvbjwvc21hbGw+IjtzOjIyOiJzaXRlX3dpZGVfYnV0dG9uX2xhYmVsIjtzOjE0OiJDYWxsIHRvIGFjdGlvbiI7czoyMToic2l0ZV93aWRlX2J1dHRvbl9saW5rIjtzOjE6IiMiO3M6MTQ6ImNvcHlyaWdodF90ZXh0IjtzOjE0OiJDb3B5cmlnaHQgMjAxMyI7czoxOToiaG9tZXBhZ2VfdXNlX3NsaWRlciI7czoxOiIxIjtzOjE3OiJob21lcGFnZV9jb250ZW50MSI7czoyNjM6IjxoMSBzdHlsZT0idGV4dC1hbGlnbjogY2VudGVyOyI+Q29uZ3JhdHVsYXRpb25zITwvaDE+DQo8aDMgc3R5bGU9InRleHQtYWxpZ246IGNlbnRlcjsiPllvdXIgc2l0ZSBpcyBqdXN0IGFyb3VuZCB0aGUgY29ybmVyLjwvaDM+DQombmJzcDsNCjxwIHN0eWxlPSJ0ZXh0LWFsaWduOiBjZW50ZXI7Ij5TdGFydCBieSBnb2luZyB0bzxzdHJvbmc+IFRoZW1lIE9wdGlvbnMgLSBIb21lIFBhZ2U8L3N0cm9uZz4gc2VjdGlvbiB0byBlZGl0IHRoaXMgY29udGVudC48L3A+IjtzOjIyOiJob21lcGFnZV91c2VfcG9ydGZvbGlvIjtzOjE6IjEiO3M6MjQ6ImhvbWVwYWdlX3BvcnRmb2xpb190aXRsZSI7czo5OiJQb3J0Zm9saW8iO3M6MjM6ImhvbWVwYWdlX3BvcnRmb2xpb19tb3JlIjtzOjQ6Ik1vcmUiO3M6MTc6ImhvbWVwYWdlX2NvbnRlbnQyIjtzOjA6IiI7czoxNjoiY29udGFjdF91c2VfZ21hcCI7czoxOiIxIjtzOjE3OiJjb250YWN0X2dtYXBfbGluayI7czo4ODoiaHR0cHM6Ly9tYXBzLmdvb2dsZS5jb20vbWFwcz9obD1ybyZsbD01MS4zODQ1NTEsLTIuMzYyNzc3JnNwbj0wLjAyNjExMywwLjA2NjA0NyZ0PW0mej0xNSI7czoxMzoiY29udGFjdF9waG9uZSI7czoxNToiKzMwMDIzIDYzOSAzNzE0IjtzOjEzOiJjb250YWN0X2VtYWlsIjtzOjIyOiJjb250YWN0QHBpeGVsZ3JhZGUuY29tIjtzOjE1OiJjb250YWN0X2FkZHJlc3MiO3M6NTM6IjExMzMgQnJvYWR3YXksIFN1aXRlIDExMjQsIDxiciAvPiAgTmV3IFlvcmssIE5ZIDEwMDEwIjtzOjIwOiJjb250YWN0X2NvbnRlbnRfbGVmdCI7czo1Mjg6IjxoMT5IRUxMTyEgTEVU4oCZUyBUQUxLLjwvaDE+DQpJZiB5b3Ugd291bGQgbGlrZSB0byB0YWxrIHRvIHVzIGFib3V0IGEgcHJvamVjdCBvciB5b3UgaGF2ZSBhIHF1ZXN0aW9uLCBwbGVhc2UgZ2V0IGluIHRvdWNoLiBGaWxsIGluIG91ciBjb250YWN0IGZvcm0gYmVsb3cgYW5kIHdl4oCZbGwgZ2V0IHJpZ2h0IGJhY2sgdG8geW91Lg0KDQpXaGV0aGVyIHlvdSdyZSBsb29raW5nIHRvIGRpc2N1c3MgYSBuZXcgcHJvamVjdCBvciBzaW1wbHkgc2F5IGhlbGxvLCB3ZSdkIGxvdmUgdG8gaGVhciBmcm9tIHlvdS4NCg0KR2l2ZSB1cyBhIGNhbGwsIGRyb3AgdXMgYW4gZW1haWwgb3IgY29tZSByb3VuZCBmb3IgYSBjaGF0Lg0KDQpXZSdyZSBiYXNlZCByaWdodCBpbiB0aGUgY2VudHJlIG9mIEJhdGggb25seSBhIDE1IG1pbnV0ZSB3YWxrIGZyb20gdGhlIHRyYWluIHN0YXRpb24uIEFuZCB0aGVyZSdzIGEgYmlnIGNhciBwYXJrIGp1c3QgYWNyb3NzIGZyb20gdGhlIG9mZmljZSwgc28gd2UncmUgcmVhbGx5IGVhc3kgdG8gZ2V0IHRvLiI7czoxODoiY29udGFjdF9mb3JtX3RpdGxlIjtzOjE3OiJTZW5kIFVzIEEgTWVzc2FnZSI7czoxNToicG9ydGZvbGlvX3RpdGxlIjtzOjEzOiJPdXIgUHJvamVjdHMuIjtzOjIyOiJwb3J0Zm9saW9faGVhZGVyX2ltYWdlIjtzOjA6IiI7czoyMzoicG9ydGZvbGlvX2FyY2hpdmVfbGltaXQiO3M6MToiNiI7czoyMjoicG9ydGZvbGlvX3NpbmdsZV9sYWJlbCI7czo3OiJQcm9qZWN0IjtzOjIyOiJwb3J0Zm9saW9fcGx1cmFsX2xhYmVsIjtzOjg6IlByb2plY3RzIjtzOjIyOiJwb3J0Zm9saW9fcmV3cml0ZV9zbHVnIjtzOjE6IjEiO3M6MTQ6InBvcnRmb2xpb19zbHVnIjtzOjk6InBvcnRmb2xpbyI7czoyMjoicG9ydGZvbGlvX2FyY2hpdmVfc2x1ZyI7czowOiIiO3M6MTc6ImJsb2dfaGVhZGVyX2ltYWdlIjtzOjA6IiI7czoyMToiYmxvZ19hcmNoaXZlX3RlbXBsYXRlIjtzOjQ6ImZ1bGwiO3M6MTk6ImJsb2dfZXhjZXJwdF9sZW5ndGgiO3M6MjoiNzUiO3M6MjA6ImJsb2dfc2luZ2xlX3RlbXBsYXRlIjtzOjQ6ImZ1bGwiO3M6Mjg6ImJsb2dfc2luZ2xlX3Nob3dfc2hhcmVfbGlua3MiO3M6MToiMSI7czoyMzoiYmxvZ19zaW5nbGVfc2hvd19hdXRob3IiO3M6MToiMSI7czoyNDoicHJlcGFyZV9mb3Jfc29jaWFsX3NoYXJlIjtzOjE6IjEiO3M6MTU6ImZhY2Vib29rX2lkX2FwcCI7czowOiIiO3M6MTc6ImZhY2Vib29rX2FkbWluX2lkIjtzOjA6IiI7czoxNToiZ29vZ2xlX3BhZ2VfdXJsIjtzOjA6IiI7czoxNzoidHdpdHRlcl9jYXJkX3NpdGUiO3M6MDoiIjtzOjI2OiJzb2NpYWxfc2hhcmVfZGVmYXVsdF9pbWFnZSI7czowOiIiO3M6MTI6InNvY2lhbF9pY29ucyI7YToxMTp7czo1OiJncGx1cyI7czo2OiJnb29nbGUiO3M6ODoiZmFjZWJvb2siO3M6ODoiZmFjZWJvb2siO3M6NzoidHdpdHRlciI7czo3OiJ0d2l0dGVyIjtzOjg6ImxpbmtlZGluIjtzOjg6ImxpbmtlZGluIjtzOjc6InlvdXR1YmUiO3M6NzoieW91dHViZSI7czo5OiJpbnN0YWdyYW0iO3M6MDoiIjtzOjU6InNreXBlIjtzOjA6IiI7czo5OiJwaW50ZXJlc3QiO3M6MDoiIjtzOjY6InR1bWJsciI7czowOiIiO3M6NjoiZmxpY2tyIjtzOjA6IiI7czo1OiJ2aW1lbyI7czowOiIiO31zOjI1OiJzb2NpYWxfaWNvbnNfdGFyZ2V0X2JsYW5rIjtzOjE6IjEiO3M6MTU6InVzZV9yZXRpbmFfbG9nbyI7aTowO3M6MTY6InVzZV9nb29nbGVfZm9udHMiO2k6MDtzOjMwOiJwb3J0Zm9saW9fcmV3cml0ZV9hcmNoaXZlX3NsdWciO2k6MDtzOjE4OiJwb3J0Zm9saW9fdXNlX3RhZ3MiO2k6MDtzOjI0OiJibG9nX3Nob3dfZmVhdHVyZWRfaW1hZ2UiO2k6MDtzOjMxOiJibG9nX3NpbmdsZV9zaG93X2NvbW1lbnRzX3RpdGxlIjtpOjA7czoxNzoicmVkdXgtb3B0cy1iYWNrdXAiO3M6MToiMSI7fSMjIw==';

    $imported_options = unserialize(trim(base64_decode( $defaults ),'###'));

    if ( empty($theme_options) || !isset($theme_options["last_tab"] )) { // load options only first time
         update_option("senna_options", $imported_options );
    }
}

add_action('after_switch_theme', 'pxg_import_footer_widgets');
function pxg_import_footer_widgets(){

    /*
    * Footer widgets
    */

    $sidebars_widgets = get_option("sidebars_widgets");

//    if ( empty($footer_sidebar) ){
//
//        $defaults = generate_default_footer_widgets();
//
//        $footer_sidebar = array(
//            'sidebar-footer' => $defaults
//        );
//
//        update_option("sidebars_widgets", $footer_sidebar);
//
//    } else

    if (  isset( $sidebars_widgets["sidebar-footer"] ) && empty( $sidebars_widgets["sidebar-footer"] ) ) {

    $sidebars_widgets["sidebar-footer"] = generate_default_footer_widgets();

        update_option("sidebars_widgets", $sidebars_widgets);
    }
}

function generate_default_footer_widgets(){

    $text_widgets = get_option( "widget_text" );
    $text_widget_count = count($text_widgets);

    $recent_posts_widgets = get_option("widget_recent-posts");
    $recent_count = count($recent_posts_widgets);

    $recent_posts = '';

    $new_recent_posts_widget[(int)$recent_count+1] = array (
            'title' => 'From the Blog',
            'number' => 4,
            'show_date' => true,
        );

    if ( update_option("widget_recent-posts", $new_recent_posts_widget) ) {
        $recent_posts = 'recent-posts-'.(string)((int)$recent_count+1);

    }

    $wtext1 = '';
    $the_widget_text1 = array(
        'title' => "Widget Area",
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae felis eu diam ullamcorper hendrerit. Aliquam tempus ultrices enim, ac consectetur nibh lacinia eu.',
        'filter' => false,
    );
    $wtext2 = '';
    $the_widget_text2 = array(
         'title' => "Widget Area",
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae felis eu diam ullamcorper hendrerit. Aliquam tempus ultrices enim, ac consectetur nibh lacinia eu.',
        'filter' => false,
    );

    if ( empty( $text_widgets ) ) {

        $new_widget[2] = $the_widget_text1;
        $new_widget[3] = $the_widget_text2;

        if ( update_option( "widget_text", $new_widget ) ){

            $wtext1 = 'text-2';
            $wtext2 = 'text-3';
        }

    } else {

        $text_widgets[ $text_widget_count+1 ] = $the_widget_text1;
        $text_widgets[ $text_widget_count+2 ] = $the_widget_text2;

        if ( update_option( "widget_text", $text_widgets ) ){
            $wtext1 = 'text-'.(string)($text_widget_count+1);
            $wtext2 = 'text-'.(string)($text_widget_count+2);
        }

    }


    $new_social_links_widget[2] = array (
            'title' => ''
    );
    $ks_socials = '';
    if ( update_option("widget_senna_social_links", $new_social_links_widget) ) {
        $ks_socials = 'ks_social_links-2';
    }

    if ( !empty( $wtext1 ) && !empty( $wtext2 ) && !empty( $recent_posts ) && !empty( $ks_socials ) ){
        return array( $wtext1, $recent_posts,$wtext2,$ks_socials );
    } else {
        return false;
    }

} ?>