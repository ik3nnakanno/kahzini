
// Wait for the document to load
document.addEventListener('DOMContentLoaded', function () {
    // Find all occurrences of links with different domain names in the document
    const pattern = /(^|\s)([a-zA-Z0-9]+(\.[a-z]{2, 6}))(\/|\?|\#|\s|$)/gi;
    const nodes = document.querySelectorAll('*:not(script):not(style):not(code)');
    nodes.forEach(node => {
        if (node.nodeType === Node.TEXT_NODE) {
            const matches = node.nodeValue.match(pattern);
            if (matches) {
                matches.forEach(match => {
                    const url = `https://${match.trim()}`;
                    const link = document.createElement('a');
                    link.setAttribute('href', url);
                    link.setAttribute('target', '_blank');
                    link.style.color = 'blue';
                    link.appendChild(document.createTextNode(match.trim()));
                    node.parentNode.replaceChild(link, node);
                });
            }
        }
    });
});