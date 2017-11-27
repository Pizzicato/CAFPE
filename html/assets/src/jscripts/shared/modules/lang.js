'use strict';

export default function get_lang() {
    const URI_segments = window.location.pathname.split("/");
    // this is for staging environment only
    return (URI_segments[1] !== '~pabloguaza') ? URI_segments[1] : URI_segments[2];
};