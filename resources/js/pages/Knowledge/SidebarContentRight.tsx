import React from 'react';

interface SidebarContentProps {
    filters?: any;
    tags?: string[];
    featuredPosts?: { id: number; title: string; slug: string }[];
}

export const SidebarContentRight: React.FC<SidebarContentProps> = ({
                                                                       filters,
                                                                       tags = [],
                                                                       featuredPosts = [],
                                                                   }) => {
    return (
        <aside className="bg-[#0d0d0d] text-white p-6 rounded-xl w-full md:w-90 shadow-lg space-y-6">
            {/* Заголовок */}
            <h3 className="text-xl font-semibold text-white">Дополнительные материалы</h3>

            {/* Список тегов */}
            {tags.length > 0 && (
                <div>
                    <h4 className="font-semibold text-sm mb-2 text-gray-300">Теги:</h4>
                    <div className="flex flex-wrap gap-2">
                        {tags.map(tag => (
                            <span
                                key={tag}
                                className="bg-gray-800 hover:bg-gray-700 text-gray-100 text-xs px-2 py-1 rounded cursor-pointer transition-colors"
                            >
                                #{tag}
                            </span>
                        ))}
                    </div>
                </div>
            )}

            {/* Избранные посты */}
            {featuredPosts.length > 0 && (
                <div>
                    <h4 className="font-semibold text-sm mb-2 text-gray-300">Избранные статьи:</h4>
                    <ul className="list-disc list-inside space-y-1 text-sm text-blue-400">
                        {featuredPosts.map(post => (
                            <li key={post.id}>
                                <a
                                    href={`/posts/${post.slug}`}
                                    className="hover:underline hover:text-blue-300 transition-colors"
                                >
                                    {post.title}
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </aside>
    );
};
