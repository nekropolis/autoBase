import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { Post } from '@/types';
import DOMPurify from "dompurify";

interface Props {
    post: Post;
}

export default function PostShow({ post }: { post: Post }) {
    return (
        <AppLayout
            breadcrumbs={[
                { title: 'Главная', href: '/' },
                { title: post.title, href: '#' },
            ]}
        >
            <Head>
                <title>{post.title}</title>
                <meta property="og:title" content={post.title} />
                <meta property="og:description" content={post.excerpt} />
                <meta property="og:image" content={post.image_url} />
                <meta property="og:type" content="article" />
                <meta property="og:url" content={route().current()} />
            </Head>

            <div className="w-full max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
                <h1 className="text-2xl sm:text-3xl font-bold break-words">{post.title}</h1>

                {post.image_url && (
                    <img
                        src={post.image_url}
                        alt={post.title}
                        className="rounded-xl shadow-lg w-full max-h-[400px] sm:max-h-[500px] object-cover"
                    />
                )}

                <div
                    className="prose prose-invert max-w-none break-words"
                    dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(post.body) }}
                />
            </div>
        </AppLayout>
    );
}
