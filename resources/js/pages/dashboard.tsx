import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { type BreadcrumbItem, DashboardProps } from '@/types';
import ProblemList from '@/pages/Knowledge/ProblemList';
import InstructionList from '@/pages/Knowledge/InstructionList';
import PostPreview from "@/pages/Posts/PostPreview";
import {SidebarContentRight} from "@/pages/Knowledge/SidebarContentRight";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Главная',
        href: '/',
    },
];


export default function Dashboard({problems, instructions, filters, posts}: DashboardProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="p-4">
                <div className="flex flex-col-reverse md:flex-row gap-6">

                    <div className="w-full md:w-[70%] flex flex-col gap-4">
                        {filters.search_type === 'problems' && <ProblemList problems={problems} />}
                        {filters.search_type === 'instructions' && <InstructionList instructions={instructions} />}
                        {filters.search_type === null && (
                            <>
                                <ProblemList problems={problems} />
                                <InstructionList instructions={instructions} />
                            </>
                        )}
                        {posts.map((post) => (
                            <PostPreview key={post.id} post={post} />
                        ))}
                    </div>

                    <div className="w-full md:w-[30%]">
                        <SidebarContentRight
                            tags={['tesla', 'зарядка', 'диагностика']}
                            featuredPosts={[
                                { id: 1, title: 'Как быстро зарядить Model 3', slug: 'fast-charge-model-3' },
                                { id: 2, title: 'Ошибки CAN-шины в Leaf', slug: 'can-bus-errors-leaf' },
                            ]}
                        />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
