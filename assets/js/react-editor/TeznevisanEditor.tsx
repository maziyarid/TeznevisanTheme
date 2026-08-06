import React, { useEffect, useRef, useState, ChangeEvent } from 'react';
import '../ui/button';
import '../ui/card';
import '../ui/input';
import '../ui/textarea';
import '../ui/select';

// Local UI Components
const Button: React.FC<{
  variant?: 'default' | 'outline' | 'ghost';
  size?: 'sm' | 'md' | 'lg';
  onClick?: () => void;
  disabled?: boolean;
  children: React.ReactNode;
  className?: string;
}> = ({ variant = 'default', size = 'md', onClick, disabled, children, className = '' }) => (
  <button
    className={`btn btn-${variant} btn-${size} ${className}`}
    onClick={onClick}
    disabled={disabled}
  >
    {children}
  </button>
);

const Card: React.FC<{ children: React.ReactNode; className?: string }> = ({ children, className = '' }) => (
  <div className={`card ${className}`}>{children}</div>
);

const CardHeader: React.FC<{ children: React.ReactNode }> = ({ children }) => (
  <div className="card-header">{children}</div>
);

const CardTitle: React.FC<{ children: React.ReactNode }> = ({ children }) => (
  <h3 className="card-title">{children}</h3>
);

const CardContent: React.FC<{ children: React.ReactNode }> = ({ children }) => (
  <div className="card-content">{children}</div>
);

const Input: React.FC<{
  value?: string;
  onChange?: (e: ChangeEvent<HTMLInputElement>) => void;
  placeholder?: string;
  className?: string;
  type?: string;
}> = ({ value, onChange, placeholder, className = '', type = 'text' }) => (
  <input
    type={type}
    value={value}
    onChange={onChange}
    placeholder={placeholder}
    className={`input ${className}`}
  />
);



interface TextareaProps {
  value?: string;
  onChange?: (e: ChangeEvent<HTMLTextAreaElement>) => void;
  placeholder?: string;
  className?: string;
  style?: React.CSSProperties;
}

const Textarea = React.forwardRef<HTMLTextAreaElement, TextareaProps>(
  ({ value, onChange, placeholder, className = '', style }, ref) => (
    <textarea
      ref={ref}
      value={value}
      onChange={onChange}
      placeholder={placeholder}
      className={`textarea ${className}`}
      style={style}
    />
  )
);

const Select: React.FC<{
  value?: string;
  onValueChange?: (value: string) => void;
  children: React.ReactNode;
}> = ({ value, onValueChange, children }) => (
  <select
    value={value}
    onChange={(e) => onValueChange?.(e.target.value)}
    className="select"
  >
    {children}
  </select>
);

const SelectTrigger: React.FC<{ children: React.ReactNode }> = ({ children }) => (
  <div className="select-trigger">{children}</div>
);

const SelectValue: React.FC<{ placeholder?: string }> = ({ placeholder }) => (
  <span className="select-value">{placeholder}</span>
);

const SelectContent: React.FC<{ children: React.ReactNode }> = ({ children }) => (
  <div className="select-content">{children}</div>
);

const SelectItem: React.FC<{ value: string; children: React.ReactNode }> = ({ value, children }) => (
  <option value={value}>{children}</option>
);

interface TeznevisanEditorProps {
  postId?: string;
  postType?: string;
  initialContent?: string;
  onSave?: (content: string, meta: any) => void;
}

interface EditorState {
  title: string;
  content: string;
  excerpt: string;
  status: string;
  categories: string[];
  tags: string[];
  featuredImage: string;
  customFields: Record<string, any>;
}

const TeznevisanEditor: React.FC<TeznevisanEditorProps> = ({
  postId,
  postType = 'post',
  initialContent = '',
  onSave
}) => {
  const editorRef = useRef<HTMLTextAreaElement>(null);
  const [isLoading, setIsLoading] = useState(false);
  const [editorState, setEditorState] = useState<EditorState>({
    title: '',
    content: initialContent,
    excerpt: '',
    status: 'draft',
    categories: [],
    tags: [],
    featuredImage: '',
    customFields: {}
  });

  const [availableCategories] = useState([
    { id: '1', name: 'عمومی' },
    { id: '2', name: 'فناوری' },
    { id: '3', name: 'ورزش' },
    { id: '4', name: 'هنر' }
  ]);

  // Initialize TinyMCE-like functionality
  useEffect(() => {
    if (editorRef.current) {
      // Add basic formatting capabilities
      const toolbar = document.createElement('div');
      toolbar.className = 'editor-toolbar';
      toolbar.innerHTML = `
        <div class="toolbar-group">
          <button type="button" data-command="bold" title="Bold">
            <strong>B</strong>
          </button>
          <button type="button" data-command="italic" title="Italic">
            <em>I</em>
          </button>
          <button type="button" data-command="underline" title="Underline">
            <u>U</u>
          </button>
        </div>
        <div class="toolbar-group">
          <button type="button" data-command="insertUnorderedList" title="Bullet List">
            - List
          </button>
          <button type="button" data-command="insertOrderedList" title="Numbered List">
            1. List
          </button>
        </div>
        <div class="toolbar-group">
          <button type="button" data-command="createLink" title="Insert Link">
            Link
          </button>
          <button type="button" data-command="insertImage" title="Insert Image">
            Image
          </button>
        </div>
      `;

      // Insert toolbar before textarea
      editorRef.current.parentNode?.insertBefore(toolbar, editorRef.current);

      // Add event listeners for toolbar buttons
      toolbar.addEventListener('click', (e) => {
        const target = e.target as HTMLButtonElement;
        const command = target.getAttribute('data-command');
        
        if (command && editorRef.current) {
          e.preventDefault();
          
          switch (command) {
            case 'createLink':
              const url = prompt('Enter URL:');
              if (url) {
                insertAtCursor(`[${getSelectedText() || 'Link text'}](${url})`);
              }
              break;
            case 'insertImage':
              const imgUrl = prompt('Enter image URL:');
              if (imgUrl) {
                insertAtCursor(`![Image](${imgUrl})`);
              }
              break;
            case 'bold':
              wrapSelection('**', '**');
              break;
            case 'italic':
              wrapSelection('*', '*');
              break;
            case 'underline':
              wrapSelection('<u>', '</u>');
              break;
            case 'insertUnorderedList':
              insertList('- ');
              break;
            case 'insertOrderedList':
              insertList('1. ');
              break;
          }
        }
      });
    }

    return () => {
      // Cleanup toolbar
      const toolbar = document.querySelector('.editor-toolbar');
      if (toolbar) {
        toolbar.remove();
      }
    };
  }, []);

  const getSelectedText = (): string => {
    if (editorRef.current) {
      return editorRef.current.value.substring(
        editorRef.current.selectionStart,
        editorRef.current.selectionEnd
      );
    }
    return '';
  };

  const insertAtCursor = (text: string) => {
    if (editorRef.current) {
      const start = editorRef.current.selectionStart;
      const end = editorRef.current.selectionEnd;
      const value = editorRef.current.value;
      
      const newValue = value.substring(0, start) + text + value.substring(end);
      setEditorState(prev => ({ ...prev, content: newValue }));
      
      // Set cursor position after inserted text
      setTimeout(() => {
        if (editorRef.current) {
          editorRef.current.focus();
          editorRef.current.setSelectionRange(start + text.length, start + text.length);
        }
      }, 0);
    }
  };

  const wrapSelection = (before: string, after: string) => {
    if (editorRef.current) {
      const selectedText = getSelectedText();
      const replacement = before + selectedText + after;
      
      insertAtCursor(replacement);
    }
  };

  const insertList = (prefix: string) => {
    const selectedText = getSelectedText();
    if (selectedText) {
      const lines = selectedText.split('\n');
      const listItems = lines.map(line => prefix + line).join('\n');
      insertAtCursor(listItems);
    } else {
      insertAtCursor(prefix + 'List item');
    }
  };

  const handleSave = async (status: 'draft' | 'publish' = 'draft') => {
    setIsLoading(true);
    
    try {
      const saveData = {
        ...editorState,
        status,
        postId,
        postType
      };

      // Call WordPress REST API or custom save handler
      if (onSave) {
        await onSave(editorState.content, saveData);
      } else {
        // Default WordPress REST API call
        const response = await fetch(`/wp-json/wp/v2/${postType}s${postId ? `/${postId}` : ''}`, {
          method: postId ? 'PUT' : 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': (window as any).wpApiSettings?.nonce || ''
          },
          body: JSON.stringify({
            title: editorState.title,
            content: editorState.content,
            excerpt: editorState.excerpt,
            status: status,
            categories: editorState.categories.map(Number),
            tags: editorState.tags,
            featured_media: editorState.featuredImage ? Number(editorState.featuredImage) : 0,
            meta: editorState.customFields
          })
        });

        if (!response.ok) {
          throw new Error('Failed to save post');
        }

        const result = await response.json();
        console.log('Post saved:', result);
        
        // Show success message
        const successMsg = document.createElement('div');
        successMsg.className = 'notice notice-success';
        successMsg.innerHTML = `<p>پست با موفقیت ${status === 'publish' ? 'منتشر' : 'ذخیره'} شد.</p>`;
        document.querySelector('.wrap')?.appendChild(successMsg);
        
        setTimeout(() => successMsg.remove(), 3000);
      }
    } catch (error) {
      console.error('Save error:', error);
      // Show error message
      const errorMsg = document.createElement('div');
      errorMsg.className = 'notice notice-error';
      errorMsg.innerHTML = `<p>خطا در ذخیره پست: ${error}</p>`;
      document.querySelector('.wrap')?.appendChild(errorMsg);
      
      setTimeout(() => errorMsg.remove(), 5000);
    } finally {
      setIsLoading(false);
    }
  };

  const handleFieldChange = (field: keyof EditorState, value: string | string[]) => {
    setEditorState(prev => ({
      ...prev,
      [field]: value
    }));
  };

  const handleInputChange = (field: keyof EditorState) => (e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    handleFieldChange(field, e.target.value);
  };

  const handleSelectChange = (field: keyof EditorState) => (value: string) => {
    handleFieldChange(field, value);
  };

  return (
    <div className="teznevisan-editor bg-background min-h-screen">
      <style dangerouslySetInnerHTML={{
        __html: `
          .editor-toolbar {
            display: flex;
            gap: 8px;
            padding: 8px;
            background: #f1f1f1;
            border: 1px solid #ccc;
            border-bottom: none;
            border-radius: 4px 4px 0 0;
          }
          .toolbar-group {
            display: flex;
            gap: 4px;
          }
          .toolbar-group button {
            padding: 4px 8px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
          }
          .toolbar-group button:hover {
            background: #e1e1e1;
          }
          .editor-content {
            border-top: none;
            border-radius: 0 0 4px 4px;
          }
        `
      }} />

      {/* Header */}
      <div className="editor-header p-4 border-b bg-card">
        <div className="flex justify-between items-center">
          <h1 className="text-2xl font-bold text-foreground">
            {postId ? 'ویرایش' : 'ایجاد'} {postType === 'post' ? 'پست' : postType}
          </h1>
          <div className="flex gap-2">
            <Button
              variant="outline"
              onClick={() => handleSave('draft')}
              disabled={isLoading}
            >
              {isLoading ? 'در حال ذخیره...' : 'ذخیره پیش‌نویس'}
            </Button>
            <Button
              onClick={() => handleSave('publish')}
              disabled={isLoading}
            >
              {isLoading ? 'در حال انتشار...' : 'انتشار'}
            </Button>
          </div>
        </div>
      </div>

      <div className="editor-body grid grid-cols-1 lg:grid-cols-3 gap-4 p-4">
        {/* Main Content */}
        <div className="lg:col-span-2 space-y-4">
          {/* Title */}
          <Card>
            <CardHeader>
              <CardTitle>عنوان</CardTitle>
            </CardHeader>
            <CardContent>
              <Input
                value={editorState.title}
                onChange={handleInputChange('title')}
                placeholder="عنوان پست را وارد کنید..."
                className="text-lg"
              />
            </CardContent>
          </Card>

          {/* Content Editor */}
          <Card>
            <CardHeader>
              <CardTitle>محتوا</CardTitle>
            </CardHeader>
            <CardContent>
              <Textarea
                ref={editorRef}
                value={editorState.content}
                onChange={handleInputChange('content')}
                placeholder="محتوای پست را وارد کنید..."
                className="min-h-96 editor-content"
                style={{ fontFamily: 'inherit' }}
              />
            </CardContent>
          </Card>

          {/* Excerpt */}
          <Card>
            <CardHeader>
              <CardTitle>خلاصه</CardTitle>
            </CardHeader>
            <CardContent>
              <Textarea
                value={editorState.excerpt}
                onChange={(e) => handleFieldChange('excerpt', e.target.value)}
                placeholder="خلاصه‌ای از پست (اختیاری)..."
                className="min-h-20"
              />
            </CardContent>
          </Card>
        </div>

        {/* Sidebar */}
        <div className="space-y-4">
          {/* Publish Status */}
          <Card>
            <CardHeader>
              <CardTitle>وضعیت انتشار</CardTitle>
            </CardHeader>
            <CardContent>
              <Select
                value={editorState.status}
                onValueChange={handleSelectChange('status')}
              >
                <SelectTrigger>
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="draft">پیش‌نویس</SelectItem>
                  <SelectItem value="publish">منتشر شده</SelectItem>
                  <SelectItem value="private">خصوصی</SelectItem>
                  <SelectItem value="pending">در انتظار بررسی</SelectItem>
                </SelectContent>
              </Select>
            </CardContent>
          </Card>

          {/* Categories */}
          <Card>
            <CardHeader>
              <CardTitle>دسته‌بندی‌ها</CardTitle>
            </CardHeader>
            <CardContent>
              <div className="space-y-2">
                {availableCategories.map(category => (
                  <label key={category.id} className="flex items-center gap-2">
                    <input
                      type="checkbox"
                      checked={editorState.categories.includes(category.id)}
                      onChange={(e) => {
                        const newCategories = e.target.checked
                          ? [...editorState.categories, category.id]
                          : editorState.categories.filter(id => id !== category.id);
                        handleFieldChange('categories', newCategories);
                      }}
                    />
                    <span className="text-sm">{category.name}</span>
                  </label>
                ))}
              </div>
            </CardContent>
          </Card>

          {/* Tags */}
          <Card>
            <CardHeader>
              <CardTitle>برچسب‌ها</CardTitle>
            </CardHeader>
            <CardContent>
              <Input
                placeholder="برچسب‌ها را با کاما جدا کنید..."
                value={editorState.tags.join(', ')}
                onChange={(e) => {
                  const tags = e.target.value.split(',').map(tag => tag.trim()).filter(Boolean);
                  handleFieldChange('tags', tags);
                }}
              />
            </CardContent>
          </Card>

          {/* Featured Image */}
          <Card>
            <CardHeader>
              <CardTitle>تصویر شاخص</CardTitle>
            </CardHeader>
            <CardContent>
              <div className="space-y-2">
                <Input
                  placeholder="URL تصویر..."
                  value={editorState.featuredImage}
                  onChange={(e) => handleFieldChange('featuredImage', e.target.value)}
                />
                {editorState.featuredImage && (
                  <img 
                    src="https://placeholder-image-service.onrender.com/image/200x150?prompt=Featured image preview showing selected image for blog post&id=a691cbea-ba25-43f3-9c2e-b2d002e95088&customer_id=cus_SmK5FdHuJUVKUI"
                    alt="Featured image preview"
                    className="w-full rounded border"
                  />
                )}
              </div>
            </CardContent>
          </Card>

          {/* Custom Fields */}
          <Card>
            <CardHeader>
              <CardTitle>فیلدهای سفارشی</CardTitle>
            </CardHeader>
            <CardContent>
              <div className="space-y-2">
                <Input placeholder="نام فیلد..." />
                <Input placeholder="مقدار..." />
                <Button variant="outline" size="sm">
                  افزودن فیلد
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  );
};

export default TeznevisanEditor;