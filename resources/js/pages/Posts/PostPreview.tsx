import {Link} from "@inertiajs/react";

type Props = {
    post: any;
};

export default function PostPreview({ post }: Props) {
    return (
        <div className="border p-4 rounded shadow flex flex-col md:flex-row items-start gap-4">
            {post.image_url && (
                <img
                    src={post.image_url}
                    alt={post.title}
                    className="rounded w-full md:w-48 max-h-60 object-cover"
                />
            )}
            <div className="flex-1 border p-4 rounded w-full">
                <h2 className="text-xl font-semibold">{post.title}</h2>
                <p className="text-gray-600">{post.excerpt}</p>
                <Link href={`/posts/${post.slug}`} className="text-blue-600 hover:underline">
                    Читать далее
                </Link>
            </div>
        </div>
    );
}
