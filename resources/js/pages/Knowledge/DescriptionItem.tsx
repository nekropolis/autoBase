import React, { useRef, useState } from 'react';
import DOMPurify from 'dompurify';

interface DescriptionItemProps {
    description: string;
}

export const DescriptionItem: React.FC<DescriptionItemProps> = ({ description }) => {
    const [expanded, setExpanded] = useState(false);
    const containerRef = useRef<HTMLLIElement>(null);

    const cleanHtml = DOMPurify.sanitize(description);

    const getTruncatedText = (html: string, limit: number) => {
        const div = document.createElement('div');
        div.innerHTML = html;
        const text = div.textContent || div.innerText || '';
        return text.length > limit ? text.slice(0, limit) + '…' : text;
    };

    const shouldTruncate = (() => {
        const div = document.createElement('div');
        div.innerHTML = cleanHtml;
        const text = div.textContent || div.innerText || '';
        return text.length > 400;
    })();

    const handleCollapse = () => {
        setExpanded(false);
        setTimeout(() => {
            containerRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    };

    return (
        <span
            ref={containerRef}
            className="text-xm leading-relaxed list-disc list-inside transition-all duration-300 text-gray-500"
        >
            {!expanded ? (
                <>
                    <div>{getTruncatedText(cleanHtml, 400)}</div>
                    {shouldTruncate && (
                        <div className="flex justify-start mt-1">
                            <span
                                onClick={() => setExpanded(true)}
                                className="text-blue-600 hover:underline text-xs cursor-pointer"
                            >
                                Читать полностью
                            </span>
                        </div>
                    )}
                </>
            ) : (
                <>
                    <div
                        dangerouslySetInnerHTML={{ __html: cleanHtml }}
                        className="prose max-w-none animate-fade-in"
                    />
                    {shouldTruncate && (
                        <div className="flex justify-start mt-2">
                            <span
                                onClick={handleCollapse}
                                className="text-blue-600 hover:underline text-xs cursor-pointer"
                            >
                                Свернуть
                            </span>
                        </div>
                    )}
                </>
            )}
        </span>
    );
};
